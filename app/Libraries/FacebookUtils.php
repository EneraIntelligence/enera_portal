<?php

namespace Portal\Libraries;

use Facebook;

class FacebookUtils
{

    private $fb;
    private $helper;
    private $accessToken;

    public function __construct()
    {
        if(!$this->fb)
        {
            if(!isset($_SESSION)){
                session_start();
            }
            $this->fb = new Facebook\Facebook([
                'app_id' => '498129860361530',
                'app_secret' => '60e173239b26b4c070785f31318b3e94',
                'default_graph_version' => 'v2.2',
            ]);
        }

    }

    public function makeLoginUrl($redirectUrl)
    {
        $this->helper = $this->fb->getRedirectLoginHelper();

        $permissions = ['email', 'user_likes', 'user_birthday', 'user_location'];
        $loginUrl = $this->helper->getLoginUrl($redirectUrl, $permissions);
        return htmlspecialchars($loginUrl);
    }

    public function isUserLoggedIn()
    {
        if(isset($this->accessToken))
            return true;

        if(!isset($this->helper))
        {
            $this->helper = $this->fb->getRedirectLoginHelper();
        }

        try {
            $this->accessToken = $this->helper->getAccessToken();
            $this->fb->setDefaultAccessToken($this->accessToken);
            return true;
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            return false;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return false;
        }


    }

    public function getUserData()
    {
        if(!$this->isUserLoggedIn())
            return null;

        try {
            $response = $this->fb->get('/me');
            $userNode = $response->getGraphUser();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            return null;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }

        return $userNode->asArray();
    }

    public function getUserLikes()
    {
        if(!$this->isUserLoggedIn())
            return null;

        $userLikes=[];
        $currentPage = 0;
        $userPartialLikes=null;

        do
        {
            $allLikesGot=true;

            try {
                if($currentPage==0)
                {
                    //Facebook limit on likes is 100 (24/09/2015)
                    $response = $this->fb->get('/me/likes?limit=10000');//fields=id,name
                    $userPartialLikes = $response->getGraphEdge();
                }
                else
                {
                    $userPartialLikes = $this->fb->next($userPartialLikes);
                }

            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                return null;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                return null;
            }

            if(isset($userPartialLikes))
            {
                //fill the array of likes jut with the like id
                /*
                foreach ($userPartialLikes as $like)
                {
                    $userLikes[] = $like->asArray()['id'];
                }*/

                //get all the data
                $userLikes = array_merge($userLikes,$userPartialLikes->asArray());

                $currentPage++;

                //if the 'next' cursor has something is because there are more pages with likes
                if($userPartialLikes->getNextCursor()!=null)
                    $allLikesGot=false;
            }

        }while(!$allLikesGot);


        return $userLikes;
    }


}