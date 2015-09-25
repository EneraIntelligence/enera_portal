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
            session_start();
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

        $permissions = ['email', 'user_likes'];
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

        return $userNode;
    }

    public function getUserLikes()
    {
        if(!$this->isUserLoggedIn())
            return null;

        $userTotalLikes=[];
        $currentPage = 0;
        $userLikes=null;

        do
        {
            $allLikesGot=true;

            try {
                if($currentPage==0)
                {
                    //Facebook limit on likes is 100 (24/09/2015)
                    $response = $this->fb->get('/me/likes?limit=10000');//fields=id,name
                    $userLikes = $response->getGraphEdge();
                }
                else
                {
                    $userLikes = $this->fb->next($userLikes);
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

            if(isset($userLikes))
            {
                //fill the array of likes
                foreach ($userLikes as $like)
                {
                    $userTotalLikes[] = [
                        'name'=>$like->asArray()['name'],
                        'date'=>$like->asArray()['created_time']->format('Y-m-d H:i')
                    ];
                }

                $currentPage++;

                if($userLikes->getNextCursor()!=null)
                    $allLikesGot=false;
            }

        }while(!$allLikesGot);


        return $userTotalLikes;
    }


}