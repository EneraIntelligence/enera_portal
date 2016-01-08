<?php

namespace Portal\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

use Input;
use Jenssegers\Agent\Agent;
use MongoDate;
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
         * base_grant_url=https%3A%2F%2Fn126.network-auth.com%2Fsplash%2Fgrant&
         * user_continue_url=http%3A%2F%2Fenera.mx&
         * node_id=15269408&
         * node_mac=00:18:0a:e8:fe:20&
         * gateway_id=15269408&
         * client_ip=10.77.147.207&
         * client_mac=24:a0:74:ed:e6:16
         */
        // valida que los paramatros esten presentes
        $validate = Validator::make(Input::all(), [
            'base_grant_url' => 'required',
            'user_continue_url' => 'required',
            'node_mac' => 'required',
//            'client_ip' => 'required',
            'client_mac' => 'required'
        ]);
        if ($validate->passes()) {
            $branche = Branche::whereIn('aps', [Input::get('node_mac')])->first();
            // Si el AP fue dado de alta y asignado a una Branche
            if ($branche) {
                // welcome
                $log = CampaignLog::where('user.session', $this->token)
                    ->where('device.mac', $this->client_mac)->first();

                // Paso 1: Welcome log
                if (!$log) {
                    $new_log = CampaignLog::create([
                        'user' => [
                            'session' => session('_token')
                        ],
                        'device' => [
                            'mac' => Input::get('client_mac')
                        ],
                        'interaction' => [
                            'welcome' => new MongoDate()
                        ]
                    ]);
                    if (!$new_log) {
                        Bugsnag::notifyError("CreateDocument", "El documento CampaignLog no se pudo crear client_mac: " . $this->client_mac);
                    }
                }

                $this->dispatch(new WelcomeLogJob([
                    'session' => session('_token'),
                    'client_mac' => Input::get('client_mac'),
                ]));

                session([
                    'main_bg' => $branche->portal['background'],
                    'session_time' => ($branche->portal['session_time'] * 60)
                ]);

                $user = User::where('facebook.id', 'exists', true)
                    ->where('devices.mac', Input::get('client_mac'))
                    ->where('devices.updated_at', '>', new MongoDate(strtotime(Carbon::today()->subDays(7)->format('Y-m-d') . 'T00:00:00-0500')))
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
                    $agent = new Agent();
                    if ($agent->is('iPhone')) {
                        $os = 'Iphone';
                    } elseif ($agent->is('Android')) {
                        $os = 'Android';
                    } elseif ($agent->is('OS X')) {
                        $os = 'OS X';
                    } else {
                        $os = 'Dipositivo no detectado';
                    }

                    session([
                        'user_email' => $user[0]->facebook->email,
                        'user_name' => $user[0]->facebook->first_name,
                        'user_fbid' => $user[0]->facebook->id,
                        'user_ftime' => false,
                        'device_os' => $os,
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
        return view('welcome.invalid', [
            'main_bg' => 'bg_welcome.jpg'
        ]);
    }

    /**
     * Obtiene la respuesta desde Facebook
     */
    public function response()
    {

        if (!$this->fbUtils->isUserLoggedIn()) {
            echo "User is not logged in";
            return "";
        }

        $facebook_data = $this->fbUtils->getUserData();
        $likes = $this->fbUtils->getUserLikes();

        //upsert user data
        $user_fb_id = $facebook_data['id'];
        $facebook_data['likes'] = [];

        $user = User::where('facebook.id', $user_fb_id)->first();
        if ($user) {
            foreach ($facebook_data as $k => $v) {
                $user->facebook->{$k} = $v;
            }
            $user->facebook->save();
        } else {
            $user = User::create(['facebook' => $facebook_data]);
        }

        $agent = new Agent();
        if ($agent->is('iPhone')) {
            $os = 'Iphone';
        } elseif ($agent->is('Android')) {
            $os = 'Android';
        } elseif ($agent->is('OS X')) {
            $os = 'OS X';
        } else {
            $os = 'Dipositivo no detectado';
        }

        session([
            'user_email' => isset($facebook_data['email']) ? $facebook_data['email'] : '',
            'user_name' => $facebook_data['first_name'],
            'user_fbid' => $user_fb_id,
            'user_ftime' => true,
            'device_os' => $os,
        ]);

        //este job maneja los likes por separado
        $chuck = array_chunk($likes, 100);
        foreach ($chuck as $shard) {
            $this->dispatch(new FbLikesJob($shard, $user_fb_id, Input::get('client_mac')));
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
}
