<?php

namespace Portal\Libraries;

use Facebook;
use Session;

class FacebookUtils
{

    private $fb;
    private $helper;
    private $accessToken;

    public function __construct()
    {
        if (!$this->fb) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $this->fb = new Facebook\Facebook([
                'app_id' => env('FB_APP_ID', '282363058604879'),
                'app_secret' => env('FB_APP_SECRET', 'b61e5fe63f4c5e0544ad94684a9c3ec9'),
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
        if (!isset($_SESSION['facebook_access_token'])) {
            if (!isset($this->helper)) {
                $this->helper = $this->fb->getRedirectLoginHelper();
            }

            if ($this->accessToken = $this->helper->getAccessToken()) {
                $_SESSION['facebook_access_token'] = (string)$this->accessToken;
                $this->fb->setDefaultAccessToken($this->accessToken);
                return true;
            } else {
                return false;
            }
        } else {
            $this->accessToken = $_SESSION['facebook_access_token'];
            $this->fb->setDefaultAccessToken($this->accessToken);
            return true;
        }
    }

    public function getUserData()
    {
        if (!$this->isUserLoggedIn())
            return null;

        try {
            $response = $this->fb->get('/me');
            $userNode = $response->getGraphUser();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            return null;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }

        return $userNode->asArray();
    }

    public function getUserLikes()
    {
        if (!$this->isUserLoggedIn())
            return null;

        $userLikes = [];
        $currentPage = 0;
        $userPartialLikes = null;

        do {
            $allLikesGot = true;

            try {
                if ($currentPage == 0) {
                    //Facebook limit on likes is 100 (24/09/2015)
                    $response = $this->fb->get('/me/likes?limit=10000');//fields=id,name
                    $userPartialLikes = $response->getGraphEdge();
                } else {
                    $userPartialLikes = $this->fb->next($userPartialLikes);
                }

            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                return null;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                return null;
            }

            if (isset($userPartialLikes)) {
                //fill the array of likes jut with the like id
                /*
                foreach ($userPartialLikes as $like)
                {
                    $userLikes[] = $like->asArray()['id'];
                }*/

                //get all the data
                $userLikes = array_merge($userLikes, $userPartialLikes->asArray());

                $currentPage++;

                //if the 'next' cursor has something is because there are more pages with likes
                if ($userPartialLikes->getNextCursor() != null)
                    $allLikesGot = false;
            }

        } while (!$allLikesGot);


        return $userLikes;
    }


}