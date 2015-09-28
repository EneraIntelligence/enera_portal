<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
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

        return view('welcome.fblogin',compact('loginUrl'));
    }

    public function login_response()
    {
        $fbUtils = new FacebookUtils();

        if(!$fbUtils->isUserLoggedIn())
        {
            echo "User is not logged in";
            return "";
        }

        $userData['facebook'] = $fbUtils->getUserData();
        $userData['facebook']['likes'] = $fbUtils->getUserLikes();

        //dd($userData);

        //save user's facebook data
        //$user = new User();
        //dd($user);
        //$user->save();
        //$user->facebook()->create($userData['facebook']);

        $userFBID = $userData['facebook']['id'];
        DB::collection('users')->where('facebook.id', $userFBID)
                    ->update($userData, array('upsert' => true));

        return view('welcome.fbresults',compact('userData'));

    }


}
