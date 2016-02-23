<?php

namespace Portal\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

use Input;
use Jenssegers\Agent\Agent;
use MongoDate;
use MongoId;
use Monolog\Handler\Mongo;
use Portal\Branche;
use Portal\CampaignLog;
use Portal\Http\Requests;
use Portal\Jobs\FbLikesJob;
use Portal\Jobs\WelcomeLogJob;
use Portal\Http\Controllers\Controller;
use Portal\Libraries\FacebookUtils;
use Portal\User;
use Validator;

class WelcomeController extends Controller
{
    protected $fbUtils;

    public function __construct()
    {
        $this->fbUtils = new FacebookUtils();
    }

    /**
     * Muestra la pantalla de bievenida a la red
     *
     * @return Response
     */
    public function index()
    {
        /*
        $apBrand = $this->detectApBrand(Input::all());
        $params = $this->getParams(Input::all(),$apBrand);
        */

        // valida que los parámetros estén presentes
        $validate = Validator::make(Input::all(), [
            'base_grant_url' => 'required',
            'user_continue_url' => 'required',
            'node_mac' => 'required',
            'client_mac' => 'required'
        ]);
        if ($validate->passes()) {
            $branche = Branche::whereIn('aps', [Input::get('node_mac')])->first();
            // Si el AP fue dado de alta y asignado a una Branche
            if ($branche) {
                $agent = new Agent();
                // welcome
                $log = CampaignLog::where('user.session', session('_token'))
                    ->where('device.mac', Input::get('client_mac'))->first();

                // Paso 1: Welcome log
                if (!$log) {
                    $new_log = CampaignLog::create([
                        'user' => [
                            'session' => session('_token')
                        ],
                        'device' => [
                            'mac' => Input::get('client_mac'),
                            'node_mac' => Input::get('node_mac'),
                            'os' => $agent->platform(),
                            'branch_id' => Branche::whereIn('aps', [Input::get('node_mac')])->first()->_id,
                        ]
                    ]);
                    $new_log->interaction()->create([
                        'welcome' => new MongoDate(),
                    ]);
                }
                $this->dispatch(new WelcomeLogJob([
                    'session' => session('_token'),
                    'client_mac' => Input::get('client_mac'),
                    'node_mac' => Input::get('node_mac'),
                    'os' => $agent->platform(),
                ]));

                session([
                    'main_bg' => $branche->portal['background'],
                    'session_time' => ($branche->portal['session_time'] * 60),
                    'device_os' => $agent->platform(),
                ]);

                $user = User::where('facebook.id', 'exists', true)
                    ->where(function ($q) {
                        $q->where('devices.mac', Input::get('client_mac'))
                            ->where('devices.updated_at', '>', new MongoDate(strtotime(Carbon::today()->subDays(30)->format('Y-m-d') . 'T00:00:00-0600')));
                    })
                    ->get();

                if ($user->count() < 1 || $user->count() > 1) {
                    $url = route('welcome::response', [
                        'node_mac' => Input::get('node_mac'),
                        'client_ip' => Input::get('client_ip'),
                        'client_mac' => Input::get('client_mac'),
                        'base_grant_url' => Input::get('base_grant_url'),
                        'user_continue_url' => Input::get('user_continue_url'),
                    ]);

                    return view('welcome.index', [
                        'image' => $branche->portal['image'],
                        'message' => $branche->portal['message'],
                        'spinner_color' => $branche->portal['spinner_color'],
                        'login_response' => $this->fbUtils->makeLoginUrl($url),
                    ]);

                } elseif ($user->count() == 1) {
                    session([
                        'user_email' => $user[0]->facebook->email,
                        'user_name' => $user[0]->facebook->first_name,
                        'user_fbid' => $user[0]->facebook->id,
                        'user_ftime' => false,
                    ]);

                    return redirect()->route('campaign::show', [
                        'id' => $user[0]->_id,
                        'node_mac' => Input::get('node_mac'),
                        'client_ip' => Input::get('client_ip'),
                        'client_mac' => Input::get('client_mac'),
                        'base_grant_url' => Input::get('base_grant_url'),
                        'user_continue_url' => Input::get('user_continue_url'),
                    ]);
                }
            }
        }


        $openMeshValidator = Validator::make(Input::all(), [
            'res' => 'required',
            'uamip' => 'required',
            'uamport' => 'required',
            'mac' => 'required',
            'called' => 'required',
            'ssid' => 'required',
            'userurl' => 'required',
            'challenge' => 'required',
        ]);

        if ($openMeshValidator->passes())
        {
            //connected via openmesh
            $uam_secret = "3n3r41nt3ll1g3nc3";

            $username="test";
            $password = "test";
            $uamip = Input::get('uamip');
            $uamport = Input::get('uamport');
            $challenge = Input::get('challenge');

            $encoded_password = $this->encode_password($password, $challenge, $uam_secret);

            $redirect_url = "http://$uamip:$uamport/logon?" .
                "username=" . urlencode($username) .
                "&password=" . urlencode($encoded_password);

            //$redirect_url .= "&redir=" . urlencode( Input::get('userurl') );


            return view('welcome.openmesh', [
                'res' => Input::get('res'),
                'redirect_url' => $redirect_url
            ]);


        }

        //Bugsnag::notifyError("Error red invalida", "Falta algún parametro en la url o el node_mac es incorrecto");


        return view('welcome.invalid', [
            'main_bg' => 'bg_welcome.jpg'
        ]);
    }

    public function openMeshAuth()
    {
        /**
         * secret - Shared secret between server and node
         */
        $secret = "3n3r41nt3ll1g3nc3";
        /**
         * response - Standard response (is modified depending on the result
         */
        $response = array(
            'CODE' => 'REJECT',
            'RA' => '0123456789abcdef0123456789abcdef',
            'BLOCKED_MSG' => 'Rejected! This doesnt look like a valid request',
        );

        /* copy request authenticator */
        if (array_key_exists('ra', $_GET) && strlen($_GET['ra']) == 32 && ($ra = hex2bin($_GET['ra'])) !== FALSE && strlen($ra) == 16) {
            $response['RA'] = $_GET['ra'];
        }

        /* decode password when available */
        $password = FALSE;
        if (array_key_exists('username', $_GET) && array_key_exists('password', $_GET))
            $password = $this->decode_password($response, $_GET['password'], $secret);

        /* store mac when available */
        $mac = FALSE;
        if (array_key_exists('mac', $_GET))
            $mac = $_GET['mac'];

        /* decode request */
        if (array_key_exists('type', $_GET)) {
            $type = $_GET['type'];
            switch ($type) {
                case 'login':
                    if ($password === FALSE)
                        break;
                    if ($password == 'test' && $_GET['username'] == 'test') {
                        unset($response['BLOCKED_MSG']);
                        $response['CODE'] = "ACCEPT";
                        $response['SECONDS'] = 900;
                        $response['DOWNLOAD'] = 2000;
                        $response['UPLOAD'] = 800;
                    } else {
                        $response['BLOCKED_MSG'] = "Invalid username or password";
                    }
                    break;
            };
        }


        /* calculate new request authenticator based on answer and request -> send it out */
        $this->calculate_new_ra($response, $secret);
        $this->print_dictionary($response);

        //echo ":)";
    }



    /**
     * Obtiene la respuesta desde Facebook
     */
    public function response()
    {

        if (!$this->fbUtils->isUserLoggedIn()) {
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

        //upsert user data
        $user_fb_id = $facebook_data['id'];
        $facebook_data['likes'] = [];

        $agent = new Agent();

        $user = User::where('facebook.id', $user_fb_id)->first();
        if ($user) {
            foreach ($facebook_data as $k => $v) {
                $user->facebook->{$k} = $v;
            }
            $user->facebook->save();

            $device = $user->devices()->where('devices.mac', Input::get('client_mac'))->first();
            if ($device) {
                $device->mac = Input::get('client_mac');
                $device->save();
            }
        } else {
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
        $chuck = array_chunk($likes, 100);
        foreach ($chuck as $shard) {
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


    /**
     * Muestra la pantalla de red invalida
     */
    public function invalid()
    {
        //
    }


    /*
     * FUNCIONES AUXILIARES OPEN-MESH
     */
    /**
     * print_dictionary - Print dictionary as encoded key-value pairs
     * @dict: Dictionary to print
     */
    private function print_dictionary($dict)
    {
        foreach ($dict as $key => $value) {
            echo '"', rawurlencode($key), '" "', rawurlencode($value), "\"\n";
        }
    }
    /**
     * calculate_new_ra - calculate new request authenticator based on old ra, code
     *  and secret
     * @dict: Dictionary containing old ra and code. new ra is directly stored in it
     * @secret: Shared secret between node and server
     */
    private function calculate_new_ra(&$dict, $secret)
    {
        if (!array_key_exists('CODE', $dict))
            return;
        $code = $dict['CODE'];
        if (!array_key_exists('RA', $dict))
            return;
        if (strlen($dict['RA']) != 32)
            return;
        $ra = hex2bin($dict['RA']);
        if ($ra === FALSE)
            return;

        $dict['RA'] = hash('md5', $code . $ra . $secret);
    }

    /**
     * decode_password - decode encoded password to ascii string
     * @dict: dictionary containing request RA
     * @encoded: The encoded password
     * @secret: Shared secret between node and server
     *
     * Returns decoded password or FALSE on error
     */
    private function decode_password($dict, $encoded, $secret)
    {
        if (!array_key_exists('RA', $dict))
            return FALSE;
        if (strlen($dict['RA']) != 32)
            return FALSE;
        $ra = hex2bin($dict['RA']);
        if ($ra === FALSE)
            return FALSE;
        if ((strlen($encoded) % 32) != 0)
            return FALSE;
        $bincoded = hex2bin($encoded);
        $password = "";
        $last_result = $ra;
        for ($i = 0; $i < strlen($bincoded); $i += 16) {
            $key = hash('md5', $secret . $last_result, TRUE);
            for ($j = 0; $j < 16; $j++)
                $password .= $key[$j] ^ $bincoded[$i + $j];
            $last_result = substr($bincoded, $i, 16);
        }
        $j = 0;
        for ($i = strlen($password); $i > 0; $i--) {
            if ($password[$i - 1] != "\x00")
                break;
            else
                $j++;
        }
        if ($j > 0) {
            $password = substr($password, 0, strlen($password) - $j);
        }

        return $password;
    }

    /*
     * encodes the challenge with the secret for open-mesh login
     */
    private function encode_password($plain, $challenge, $secret) {
        if ((strlen($challenge) % 2) != 0 ||
            strlen($challenge) == 0)
            return FALSE;

        $hexchall = hex2bin($challenge);
        if ($hexchall === FALSE)
            return FALSE;

        if (strlen($secret) > 0) {
            $crypt_secret = md5($hexchall . $secret, TRUE);
            $len_secret = 16;
        } else {
            $crypt_secret = $hexchall;
            $len_secret = strlen($hexchall);
        }

        /* simulate C style \0 terminated string */
        $plain .= "\x00";
        $crypted = '';
        for ($i = 0; $i < strlen($plain); $i++)
            $crypted .= $plain[$i] ^ $crypt_secret[$i % $len_secret];

        $extra_bytes = 0;//rand(0, 16);
        for ($i = 0; $i < $extra_bytes; $i++)
            $crypted .= chr(rand(0, 255));

        return bin2hex($crypted);
    }

}
