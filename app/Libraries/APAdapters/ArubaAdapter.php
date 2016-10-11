<?php

namespace Portal\Libraries\APAdapters;

use Portal\Libraries\APAdapters\IAdapter;
use Validator;


class ArubaAdapter implements IAdapter
{

    public function processInput($input)
    {

        /**
        "cmd" : "login",
        "mac" : "90:68:c3:62:71:cf",
        "essid" : "#ArubaDev",
        "ip" : "172.31.98.254",
        "apname" : "6c:f3:7f:c5:34:1c",
        "vcname" : "instant-C5:34:1C",
        "switchip" : "securelogin.arubanetworks.com",
        "url" : "http://connectivitycheck.gstatic.com/generate_204"
         */

        $arubaValidator = Validator::make( $input, [
            'cmd' => 'required',
            'mac' => 'required',
            'apname' => 'required',
            'switchip' => 'required',
            'url' => 'required',
        ]);



        if ($arubaValidator->passes())
        {

/*
            if ($input['res'] === "success") 
            {
                $this->redirectToEnera();
                return [];
            }
*/

            
            $redirect_url = $input['switchip'];


            $user_url = $input['url'];
            
            if(!isset($user_url) || $user_url=="")
            {
                $user_url = "http://enera.mx/";
            }

            $redirect_url .= "&redir=" . urlencode( $user_url );


            $node_mac = $this->formatMac($input['apname']);
            $client_mac =  $this->formatMac($input['mac']);
            
            //variables converted to match meraki's
            $resp = [
                'base_grant_url' => $redirect_url,
                'user_continue_url' => $user_url,
                'node_mac' => $node_mac,
                'client_mac' => $client_mac
            ];

            return $resp;
        }

        //validation failed goto invalid portal
        return [];
    }
    
    public function validateUserContinueURL($url, $defaultURL)
    {
        return $url;
    }

    public function addVars($url, $vars)
    {
        $first = true;

        //checks if the url already has variables
        if (strpos($url, '?') !== FALSE)
            $first=false;

        foreach ($vars as $key => $value) {
            if($value!="")
            {
                if($first)
                {
                    //adding the first var
                    $first=false;
                    $url = $url.'?'.urlencode( $key ) .'='. urlencode($value);
                }
                else
                {
                    //adding a var that is not the first one
                    $url = $url.'&'.urlencode( $key ) .'='. urlencode($value);
                }
            }
        }
        return $url;
    }

    private function formatMac($mac)
    {
        $res = strtolower($mac);
        return str_replace("-", ":", $res);
    }


}