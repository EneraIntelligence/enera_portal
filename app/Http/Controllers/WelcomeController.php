<?php

namespace Portal\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use Input;
use MongoDate;
use Portal\Branche;
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

                // Job: paso 1 welcome log
                $this->dispatch(new WelcomeLogJob([
                    'session' => session('_token'),
                    'client_mac' => Input::get('client_mac'),
                ]));

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

        $user_data['facebook'] = $this->fbUtils->getUserData();
        $likes = $this->fbUtils->getUserLikes();

        //upsert user data
        $user_fb_id = $user_data['facebook']['id'];
        $user_data['facebook']['likes'] = [];

        User::where('facebook.id', $user_fb_id)
            ->update($user_data, array('upsert' => true));

        $user = User::where('facebook.id', $user_fb_id)->first();

        session(['user_mail' => $user_data['facebook']['email']]);

        $this->dispatch(new FbLikesJob($likes, $user_fb_id));

        return redirect()->route('campaign::show', ['id' => $user->_id]);
    }


    /**
     * Muestra la pantalla de red invalida
     */
    public function invalid()
    {
        //
    }
}
