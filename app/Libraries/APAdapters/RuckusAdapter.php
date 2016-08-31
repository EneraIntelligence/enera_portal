<?php

namespace Portal\Libraries\APAdapters;

use Portal\Libraries\APAdapters\IAdapter;
use URL;
use Validator;


class RuckusAdapter implements IAdapter
{

    public function processInput($input)
    {
        /**
         * Example
         * 
            "sip" : "192.168.128.14",
            "mac" : "6caab32da890", 
            "client_mac" : "c0eefb2155fb", 
            "uip" : "192.168.128.18", 
            "lid" : "", 
            "dn" : "", 
            "url" : "http://www.joyeux.com.mx/", 
            "ssid" : "WIFI_RUCKUS", 
            "loc" : "", 
            "vlan" : "1"
         * 
         */

        $ruckusValidator = Validator::make( $input, [
            'sip' => 'required',
            'mac' => 'required',
            'client_mac' => 'required',
            'uip' => 'required',
            'url' => 'required',
            'ssid' => 'required',
            'vlan' => 'required',
        ]);

        if ($ruckusValidator->passes())
        {
            $node_mac = $this->formatMac($input['mac']);
            $client_mac = $this->formatMac($input['client_mac']);
            $user_url = $input['url'];


            $resp = [
                'base_grant_url' => URL::route('radius-connect'),
                'user_continue_url' => $user_url,
                'node_mac' => $node_mac,
                'client_mac' => $client_mac
            ];

            return $resp;
            
        }


        //error validating
        return [];
    }

    /**
     * @param $mac
     * @return string
     * @description converts a mac address like "aabbaabb" to a valid format "aa:bb:aa:bb"
     */
    private function formatMac($mac)
    {
        $mac = strtolower($mac);

        $length = strlen($mac);

        $res=substr($mac,0,2);

        for ($i=2; $i<$length; $i+=2) {
            $res .= ":".$mac[$i].$mac[$i+1];
        }

        return $res;
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