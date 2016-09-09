<?php

namespace Portal\Libraries\APAdapters;

use Portal\Libraries\APAdapters\IAdapter;
use URL;
use Validator;


class CiscoAdapter implements IAdapter
{

    public function processInput($input)
    {
        /**
         * Example
         *
            "switch_url" : "https://1.1.1.1/login.html",
            "ap_mac" : "84:b8:02:d3:3e:d0",
            "client_mac" : "9c:fc:01:51:93:25",
            "wlan" : "EneraWifi",
            "redirect" : "captive.apple.com/hotspot-detect.html"
         * 
         */

        $ciscoValidator = Validator::make( $input, [
            'switch_url' => 'required',
            'ap_mac' => 'required',
            'client_mac' => 'required',
            'redirect' => 'required',
        ]);

        if ($ciscoValidator->passes())
        {
            $node_mac = $input['ap_mac'];
            $client_mac = $input['client_mac'];
            $user_url = $input['redirect'];


            $resp = [
                'base_grant_url' => URL::route('cisco-connect',[ 'ip'=> urlencode($input['switch_url']), 'client_mac'=>$client_mac ]),
                'user_continue_url' => $user_url,
                'node_mac' => $node_mac,
                'client_mac' => $client_mac
            ];

            return $resp;
            
        }


        //error validating
        return [];
    }


    public function addVars($url, $vars)
    {
        $first = true;

        if (strpos($url, '?') !== FALSE)
            $first=false;

        foreach ($vars as $key => $value) {
            if($value!="")
            {
                if($first)
                {
                    $first=false;
                    $url = $url.'?'.urlencode( $key ) .'='. urlencode($value);
                }
                else
                {
                    $url = $url.'&'.urlencode( $key ) .'='. urlencode($value);
                }
            }
        }
        return $url;
    }

    public function validateUserContinueURL($url, $defaultURL)
    {
        $newURL=$url;
//        echo $newURL;
        if(strpos($url,'network-auth.com')!==false)
        {
//            echo 'la url esta vacia';
            $newURL=$defaultURL;
//            echo $newURL;
        }

        return $newURL;
    }
}