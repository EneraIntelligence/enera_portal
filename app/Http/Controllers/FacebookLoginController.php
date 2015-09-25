<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use URL;
use Portal\Libraries\FacebookUtils;


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

        return view('welcome.fblogin',compact('loginUrl'));
    }

    public function login_response()
    {
        $fbUtils = new FacebookUtils();

        if(!$fbUtils->isUserLoggedIn())
        {
            echo "fail";
            return "";
        }

        $userData = $fbUtils->getUserData();
        $userLikes = $fbUtils->getUserLikes();

        //dd($userLikes);
        dd($userData);

        return view('welcome.fbresults',compact('userData','userLikes'));

    }

}
