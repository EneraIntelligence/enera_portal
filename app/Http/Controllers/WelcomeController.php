<?php

namespace Portal\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use Input;
use MongoDate;
use Portal\AccessPoint;
use Portal\Branche;
use Portal\CampaignLog;
use Portal\Campaign;
use Portal\Http\Requests;
use Portal\Jobs\FbLikesJob;
use Portal\Libraries\CampaignSelector;
use Portal\Http\Controllers\Controller;
use Portal\Libraries\FacebookUtils;
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
//            'base_grant_url' => 'required',
//            'user_continue_url' => 'required',
            'node_mac' => 'required',
//            'client_id' => 'required',
//            'client_mac' => 'required'
        ]);
        if ($validate->passes()) {
            $branche = Branche::whereIn('aps', [Input::get('node_mac')])->first();
            // Si el AP fue dado de alta y asignado a una Branche
            if ($branche) {
                session(['main_bg' => $branche->portal['background']]);
                $url = route('welcome::response', [
                    'node_mac' => Input::get('node_mac')
                ]);
                // Paso 1: Welcome log
                DB::collection('campaign_logs')
                    ->where('user.session', session('_token'))
                    ->where('device.mac', Input::get('client_mac'))
                    ->where('interaction.welcome', 'exists', false)
                    ->update([
                        'user' => [
                            'session' => session('_token')
                        ],
                        'device' => [
                            'mac' => Input::get('client_mac')
                        ],
                        'interaction' => [
                            'welcome' => new MongoDate()
                        ],
                        'created_at' => new MongoDate()
                    ], array('upsert' => true));

                return view('welcome.index', [
                    'image' => $branche->portal['image'],
                    'message' => $branche->portal['message'],
                    'login_response' => $this->fbUtils->makeLoginUrl($url),
                ]);
            }
        }
        return view('welcome.invalid', [
            'main_bg' => 'bg_welcome.jpg'
        ]);
    }

    /**
     * Optiene la respuesta desde Facebook
     */
    public function response()
    {
        if (!$this->fbUtils->isUserLoggedIn()) {
            echo "User is not logged in";
            return "";
        }

        $userData['facebook'] = $this->fbUtils->getUserData();
        $likes = $this->fbUtils->getUserLikes();

        //upsert user data
        $userFBID = $userData['facebook']['id'];
        DB::collection('users')->where('facebook.id', $userFBID)
            ->update($userData, array('upsert' => true));

        session(['user_mail' => $userData['facebook']['email']]);

        $this->dispatch(new FbLikesJob($likes, $userFBID));

        return 'done';
    }


    /**
     * Muestra la pantalla de red invalida
     */
    public function invalid()
    {
        //
    }
}
