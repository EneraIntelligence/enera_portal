<?php

namespace Portal\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Http\Request;

use Input;
use Jenssegers\Agent\Agent;
use MongoDate;
use MongoId;
use Monolog\Handler\Mongo;
use Portal\Branche;
use Portal\CampaignLog;
use Portal\InputLog;
use Portal\Http\Requests;
use Portal\Jobs\FbLikesJob;
use Portal\Jobs\WelcomeLogJob;
use Portal\Http\Controllers\Controller;
use Portal\Libraries\FacebookUtils;
use Portal\Libraries\Radius\Radius;
use Portal\User;
use URL;
use Validator;
use Session;

//adapters
use Portal\Libraries\APAdapters\OpenMeshAdapter;
use Portal\Libraries\APAdapters\MerakiAdapter;
use Portal\Libraries\APAdapters\RuckusAdapter;
use Portal\Libraries\APAdapters\DefaultAdapter;
use Portal\Libraries\APAdapters\CiscoAdapter;
use Portal\Libraries\APAdapters\ArubaAdapter;

class WelcomeController extends Controller
{
    protected $fbUtils;

    public function __construct()
    {
        $this->fbUtils = new FacebookUtils();
    }

    private function checkSession()
    {
        $logs = CampaignLog::where('user.session', session('_token'))
            ->where('interaccion.requested', 'exists', true)->count();
        if ($logs > 0)
        {
            Session::flush();
            Session::regenerate();
        }
    }

    /**
     * Muestra la pantalla de bievenida a la red
     *
     * @return Response
     */
    public function index()
    {

        // clear session
        $this->checkSession();

        //detecta marca de ap y asigna un adaptador
        $inputAdapter = $this->detectAPAdapter(Input::all());
        //ajusta los inputs al estandar de enera
        $input = $inputAdapter->processInput(Input::all());


        if (!$this->validWelcomeInput($input))
        {
            return $this->invalidNetworkView();
        }


        //renombrando variables para mejor manejo
        $node_mac = $input['node_mac'];
        $client_mac = $input['client_mac'];
        $base_grant_url = $input['base_grant_url'];
        $user_continue_url = $input['user_continue_url'];

        session([
            'success_redirect_url' => $user_continue_url
        ]);

        //busca el branch del ap
        $branche = Branche::whereIn('aps', [$node_mac])->first();

        // Si el AP no fue dado de alta o no está asignado a una Branche
        if (!$branche)
        {
            echo 'mac-'.$input['node_mac'];
            return $this->invalidNetworkView();
        }

        //check if the user continue url is valid, if not set it to the branch default
        $user_continue_url = $inputAdapter->validateUserContinueURL($user_continue_url, $branche->portal['default_link']);
        $url_vars = [
            "duration" => $branche->portal['session_time'] * 60,
            "continue_url" => $user_continue_url
        ];
        $base_grant_url = $inputAdapter->addVars($base_grant_url, $url_vars);

        $agent = new Agent();

        // welcome
        $log = CampaignLog::where('user.session', session('_token'))
            ->where('device.mac', $client_mac)->first();


        // Paso 1: Welcome log
        if ($log && !isset($log->interaction->welcome))
        {
            //se encontró log y está vacío, sin welcome
            /* Eder: creo que nunca se entra aquí por que siempre se le agrega welcome al inicio*/
            $log->interaction()->create(['welcome' => new MongoDate()]);
        } elseif (!$log)
        {
            //no existe log, creando
            $new_log = CampaignLog::create([
                'user' => [
                    'session' => session('_token')
                ],
                'device' => [
                    'mac' => $client_mac,
                    'node_mac' => $node_mac,
                    'os' => $agent->platform(),
                    'branch_id' => Branche::whereIn('aps', [$node_mac])->first()->_id,
                ]
            ]);

            //se introduce la info de welcome
            $new_log->interaction()->create([
                'welcome' => new MongoDate(),
            ]);
        }

        session([
            'image' => $branche->portal['image'],
            'main_bg' => $branche->portal['background'],
            'message' => $branche->portal['message'],
            'session_time' => ($branche->portal['session_time'] * 60),
            'device_os' => $agent->platform(),
        ]);

        $users = User::where('facebook.id', 'exists', true)
            ->where(function ($q) use ($client_mac)
            {
                $q->where('devices.mac', $client_mac)
                    ->where('devices.updated_at', '>', new MongoDate(strtotime(Carbon::today()->subDays(30)->format('Y-m-d') . 'T00:00:00-0600')));
            })
            ->get();

//        dd($users->count());

        //check if device has paired none or more than 1 facebook account


        //fix this later :: forcing login with facebook
        if ($users->count() != 1)
        {
            $url = route('welcome::response', [
                'node_mac' => $node_mac,
                //'client_ip' => Input::get('client_ip'),
                'client_mac' => $client_mac,
                'base_grant_url' => $base_grant_url,
                'user_continue_url' => $user_continue_url
            ]);

            //open login view
            return view('welcome.index', [
                'image' => $branche->portal['image'],
                'message' => $branche->portal['message'],
                'spinner_color' => $branche->portal['spinner_color'],
                'login_response' => $this->fbUtils->makeLoginUrl($url),
                'client_mac' => $client_mac,
            ]);

        }


        //device has exactly one facebook account paired
        $user = $users[0];

        session([
            'user_email' => $user->facebook->email,
            'user_name' => $user->facebook->first_name,
            'user_fbid' => $user->facebook->id,
            'user_ftime' => false,
        ]);

        //show campaign
        return redirect()->route('campaign::show', [
            'id' => $user->_id,
            'node_mac' => $node_mac,
            //'client_ip' => Input::get('client_ip'),
            'client_mac' => $client_mac,
            'base_grant_url' => $base_grant_url,
            'user_continue_url' => $user_continue_url
        ]);

    }

    private function validWelcomeInput($input)
    {
        // valida que los parámetros estén presentes
        $validate = Validator::make($input, [
            'base_grant_url' => 'required',
            'user_continue_url' => 'required',
            'node_mac' => 'required',
            'client_mac' => 'required'
        ]);

        return $validate->passes();
    }

    private function invalidNetworkView()
    {
        return view('welcome.invalid', [
            'main_bg' => 'bg_welcome.jpg'
        ]);
    }

    private function detectAPAdapter($input)
    {

        if (isset($input['base_grant_url']))
        {
            return new MerakiAdapter();
        } else if (isset($input['res']))
        {
            return new OpenMeshAdapter();
        } else if (isset($input['sip']))
        {
            return new RuckusAdapter();
        } else if (isset($input['switch_url']))
        {
            return new CiscoAdapter();
        }else if (isset($input['apname']))
        {
            return new ArubaAdapter();
        }

        $inputLog = new InputLog;
        $inputLog->inputs = $input;
        $inputLog->save();

        return new DefaultAdapter();

    }


    /**
     * Obtiene la respuesta desde Facebook
     */
    public function response()
    {

        if (!$this->fbUtils->isUserLoggedIn())
        {
            //echo "User is not logged in";
            return redirect()->route('welcome', [
                'base_grant_url' => Input::get('base_grant_url'),
                'user_continue_url' => Input::get('user_continue_url'),
                'node_mac' => Input::get('node_mac'),
                'client_ip' => Input::get('client_ip'),
                'client_mac' => Input::get('client_mac')
            ]);
        }

        $facebook_data = $this->fbUtils->getUserData();
        $likes = $this->fbUtils->getUserLikes();

        if (isset($facebook_data['birthday']))
        {
            $start = new MongoDate(strtotime($facebook_data['birthday']));
            $facebook_data['birthday'] = array("date" => $facebook_data['birthday']);
        } else
        {
            $start = new MongoDate(strtotime("0"));
            $facebook_data['birthday'] = array("date" => "1998-01-01 00:00:00.000000");

        }

        $facebook_data['age'] = $start;

        //upsert user data
        $user_fb_id = $facebook_data['id'];
        $facebook_data['likes'] = [];

        $agent = new Agent();

        $user = User::where('facebook.id', $user_fb_id)->first();

        if ($user != null)
        {
            foreach ($facebook_data as $k => $v)
            {
                $user->facebook->{$k} = $v;
            }
            $user->facebook->save();

            $device = $user->devices()->where('devices.mac', Input::get('client_mac'))->first();
            if ($device==null)
            {

                $user->devices()->create([
                    'mac' => Input::get('client_mac'),
                    'os' => $agent->platform(),
                ]);
                /*
                $device->mac = Input::get('client_mac');
                $device->save();*/
            }
        } else
        {
            $user = User::create([
                'facebook' => $facebook_data,
                'devices' => []
            ]);

            $user->devices()->create([
                'mac' => Input::get('client_mac'),
                'os' => $agent->platform(),
            ]);
        }

        session([
            'user_email' => isset($facebook_data['email']) ? $facebook_data['email'] : '',
            'user_name' => $facebook_data['first_name'],
            'user_fbid' => $user_fb_id,
            'user_ftime' => true,
            'device_os' => $agent->platform(),
        ]);
        $device_os = $agent->platform() ? $agent->platform() : 'unknown';

        //este job maneja los likes por separado
        $chuck = array_chunk($likes != null ? $likes : [], 200);
        foreach ($chuck as $shard)
        {
            $this->dispatch(new FbLikesJob($shard, $user_fb_id, Input::get('client_mac')), $device_os);
        }

        return redirect()->route('campaign::show', [
            'id' => $user->_id,
            'base_grant_url' => Input::get('base_grant_url'),
            'user_continue_url' => Input::get('user_continue_url'),
            'node_mac' => Input::get('node_mac'),
            'client_ip' => Input::get('client_ip'),
            'client_mac' => Input::get('client_mac')
        ]);
    }

    public function welcome_loaded()
    {
        if (Input::has('client_mac'))
        {
            $client_mac = Input::get('client_mac');
            $log = CampaignLog::where('user.session', session('_token'))
                ->where('device.mac', $client_mac)->first();

            if ($log && isset($log->interaction->welcome) && !isset($log->interaction->welcome_loaded))
            {
                $log->interaction->welcome_loaded = new MongoDate();
                $log->interaction->save();

                $response = [
                    'ok' => true,
                    'msg' => '',
                ];
            } elseif ($log && !isset($log->interaction->welcome))
            {
                $response = [
                    'ok' => false,
                    'msg' => 'El campo "interaction.welcome" no existe',
                ];
            } elseif ($log && isset($log->interaction->welcome_loaded))
            {
                $response = [
                    'ok' => false,
                    'msg' => 'El campo "interaction.welcome_loaded" ya fue creado',
                ];
            } else
            {
                $response = [
                    'ok' => false,
                    'msg' => 'No existe un log para esta sesion.',
                ];
            }
        } else
        {
            $response = [
                'ok' => false,
                'msg' => 'Falta al MAC Address del cliente/dispositivo',
            ];
        }
        return response()->json($response);
    }


    /**
     * Muestra la pantalla de red invalida
     */
    public function invalid()
    {
        //
    }

    /**
     * Muestra la pantalla con ads
     */
    public function ads()
    {
        $image = "";
        $main_bg = "";
        $color = "darkgrey";
        if (Session::has('image'))
        {
            $image = session('image');
        }
        if (Session::has('main_bg'))
        {
            $main_bg = session('main_bg');
        }
        if (Session::has('message'))
        {
            $color = session('message')['color'];
        }


        /*
        http://s2s.startappnetwork.com/s2s/1.3/htmlads?
        partner=110786237&
        token=778645132&
        adw=320&
        adh=480&
        os=1&
        osVer=4.1&
        segId=65437653&
        pub=1&
        prod=com.foobar.app&
        dip=205.232.37.108&
        ua=%20Mozilla%2F5.0%20(Linux%3B%20U%3B%20Android%204.0.3%3B%20de-ch%3B%20HTC%20Sensation%20Build%2FIML74K)%20AppleWebKit%2F534.30%20(KHTML%2C%20like%20Gecko)%20Version%2F4.0%20Mobile%20Safari%2F534.30&loc=44.000000%2C-2.000000&isp=42501&gen=0&age=25&maturity=1&test=true&dId=17e3ce3518af76e4&reqId=1245
        */
        $resp="";

        return view('welcome.ads', [
            'main_bg' => $main_bg,
            'color' => $color,
            'image' => $image,
            'encodedResponse'=>$resp
        ]);
    }

    public function ruckus_radius($ip, $client_mac)
    {
        
        if (Input::has("continue_url"))
        {
            //echo Input::has("continue_url");
            session([
                'success_redirect_url' => Input::get("continue_url")
            ]);

        }

        $users = DB::connection('radius')->select("select * from radcheck where username=?", [$client_mac]);

        if (count($users) == 0)
        {
            DB::connection('radius')->insert("insert into radcheck (username,attribute,value) VALUES (?,?,?);", [$client_mac, "Password", $client_mac]);

        }

        return view("welcome.ruckus", 
            [
                'ip' => $ip, 
                'client_mac' => $client_mac
            ] 
        );

    }

    public function ruckus_nbi($ip, $client_mac)
    {

        $users = DB::connection('radius')->select("select * from radcheck where username=?", [$client_mac]);

        if (count($users) == 0)
        {
            DB::connection('radius')->insert("insert into radcheck (username,attribute,value) VALUES (?,?,?);", [$client_mac, "Password", $client_mac]);

        }


        //nbi
        //207.248.45.101

        $url = "http://207.248.45.101:9080/portalintf";

        $json_data = array(
            "Vendor" => "ruckus",
            "RequestPassword" => "t3!um123",
            "APIVersion" => "1.0",
            "RequestCategory" => "GetConfig",
            "RequestType" => "Encrypt",
            "Data" => $client_mac
        );

        $json_response = $this->makeCurl($url, $json_data);

        $response = json_decode($json_response, true);
        //$this->info("Enc-mac: " . $response['Data']);
        $encMac = $response['Data'];
        //end mac
        
        
        //start login


        $json_data = array(
            "Vendor" => "ruckus",
            "RequestPassword" => "t3!um123",
            "APIVersion" => "1.0",
            "RequestCategory" => "UserOnlineControl",
            "RequestType" => "Login",
            //"UE-IP" => $encIp,
            "UE-MAC" => $encMac,
            "UE-Proxy" => "0",
            "UE-Username" => $client_mac,
            "UE-Password" => $client_mac
        );

        $json_response = $this->makeCurl($url, $json_data);


        $response = json_decode($json_response, true);
        $rCode = $response['ResponseCode'];


        if($rCode=="201")
        {
            //success
            $client_mac = session('client_mac');
            $log = CampaignLog::where('user.session', session('_token'))
                ->where('device.mac', $client_mac)->first();

            if ($log)
            {
                //saving completed
                $log->interaction->accessed = new MongoDate();
                $log->interaction->save();
            }


            if (Session::has('success_redirect_url'))
                return redirect(session('success_redirect_url'));
            else
                return redirect(URL::route('ads'));
        }
        else
        {
            return view("welcome.ruckus", array('ip' => $ip, 'client_mac' => $client_mac,
                'query'=>json_encode($json_data),'resp'=>$json_response));
        }

    }


    private function makeCurl($url, $json_data)
    {
        $content = json_encode($json_data);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($status != 200)
        {
            //error
            die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }


        curl_close($curl);

        return $json_response;
    }

    public function cisco($ip, $client_mac)
    {
        if (Input::has("continue_url"))
        {
            //echo Input::has("continue_url");
            session([
                'success_redirect_url' => Input::get("continue_url")
            ]);

        }


        $users = DB::connection('radius')->select("select * from radcheck where username=?", [$client_mac]);

        if (count($users) == 0)
        {
            DB::connection('radius')->insert("insert into radcheck (username,attribute,value) VALUES (?,?,?);", [$client_mac, "Password", $client_mac]);

        }


        return view("welcome.cisco", array('ip' => urldecode($ip), 'client_mac' => $client_mac));
    }


    public function aruba()
    {
        return view("welcome.aruba_auth");
    }

    public function success()
    {
        if (Session::has('success_redirect_url'))
            return redirect(session('success_redirect_url'));
        else
            return redirect(URL::route('ads'));
    }


}
