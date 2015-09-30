<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Portal\FacebookPage;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use URL;
use Portal\Libraries\FacebookUtils;
use Portal\User;
use DB;

class FacebookLoginController extends Controller
{

    /**
     * Displays the facebook login button
     *
     * @return view
     */
    public function index()
    {
        $fbUtils = new FacebookUtils();
        $redirectUrl = URL::to('fb_login_response');

        $loginUrl = $fbUtils->makeLoginUrl($redirectUrl);

        return view('welcome.fblogin', compact('loginUrl'));
    }

    public function login_response()
    {
        $fbUtils = new FacebookUtils();

        if (!$fbUtils->isUserLoggedIn()) {
            echo "User is not logged in";
            return "";
        }

        $userData['facebook'] = $fbUtils->getUserData();
        $likes = $fbUtils->getUserLikes();

        //upsert each fb page that the user likes
        //TODO hacer esto asíncrono
        foreach ($likes as $like) {
            DB::collection('facebookpages')->where('id', $like['id'])
                ->update($like, array('upsert' => true));

            $userData['facebook']['likes'][] = $like['id'];
        }

        //dd($userData);

        //upsert user data
        $userFBID = $userData['facebook']['id'];
        DB::collection('users')->where('facebook.id', $userFBID)
            ->update($userData, array('upsert' => true));

        return view('welcome.fbresults', compact('userData'));

    }


}
