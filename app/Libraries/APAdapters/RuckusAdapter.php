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
         * "sip" : "192.168.128.14",
         * "mac" : "6caab32da890",
         * "client_mac" : "c0eefb2155fb",
         * "uip" : "192.168.128.18",
         * "lid" : "",
         * "dn" : "",
         * "url" : "http://www.joyeux.com.mx/",
         * "ssid" : "WIFI_RUCKUS",
         * "loc" : "",
         * "vlan" : "1"
         *
         *
         *
         * Tellum example
         *          *
         * http://portal.enera-intelligence.mx/?
         * nbiIP=192.168.223.130&
         * wlan=2158&
         * reason=Un-Auth-Captive&
         * mac=e0:10:7f:10:6a:80&
         * uip=10.196.55.100&
         * url=http%3A%2F%2Fwww.apple.com%2F&zoneName=Pruebas_ZonaYOO&
         * client_mac=90:72:40:7d:e3:0c&
         * sip=10.254.1.3&
         * StartURL=http%3A%2F%2Fportal.enera-intelligence.mx%2Fsuccess&proxy=0&
         * ssid=Enera_Test&wlanName=Enera_Test&dn=
         *
         */

        $ruckusValidator = Validator::make($input, [
            'sip' => 'required',
            'mac' => 'required',
            'client_mac' => 'required',
            'uip' => 'required',
            'url' => 'required',
            'ssid' => 'required',
//            'nbiIP' => 'required',
            //'vlan' => 'required',
        ]);

        if ($ruckusValidator->passes())
        {

            if (strpos($input['mac'], ':') !== FALSE)
            {
                $node_mac = $input['mac'];
                $client_mac = $input['client_mac'];
            } else
            {
                $node_mac = $this->formatMac($input['mac']);
                $client_mac = $this->formatMac($input['client_mac']);
            }

            $user_url = $input['url'];


            $nbiIP = $input['nbiIP'];

            if(isset($nbiIP))
            {
                $resp = [
                'base_grant_url' => URL::route('ruckus-nbi', ['ip' => $input['sip'], 'client_mac' => $client_mac]),
//                    'base_grant_url' => URL::route('radius-connect', ['ip' => $input['nbiIP'], 'client_mac' => $client_mac]),
                    'user_continue_url' => $user_url,
                    'node_mac' => $node_mac,
                    'client_mac' => $client_mac
                ];
            }
            else
            {
                $resp = [
//                'base_grant_url' => URL::route('radius-connect', ['ip' => $input['sip'], 'client_mac' => $client_mac]),
                    'base_grant_url' => URL::route('ruckus-radius', ['ip' => $input['nbiIP'], 'client_mac' => $client_mac]),
                    'user_continue_url' => $user_url,
                    'node_mac' => $node_mac,
                    'client_mac' => $client_mac
                ];
            }



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

        $res = substr($mac, 0, 2);

        for ($i = 2; $i < $length; $i += 2)
        {
            $res .= ":" . $mac[$i] . $mac[$i + 1];
        }

        return $res;
    }


    public function addVars($url, $vars)
    {
        $first = true;

        if (strpos($url, '?') !== FALSE)
            $first = false;

        foreach ($vars as $key => $value)
        {
            if ($value != "")
            {
                if ($first)
                {
                    $first = false;
                    $url = $url . '?' . urlencode($key) . '=' . urlencode($value);
                } else
                {
                    $url = $url . '&' . urlencode($key) . '=' . urlencode($value);
                }
            }
        }
        return $url;
    }

    public function validateUserContinueURL($url, $defaultURL)
    {
        $newURL = $url;
//        echo $newURL;
        if (strpos($url, 'network-auth.com') !== false)
        {
//            echo 'la url esta vacia';
            $newURL = $defaultURL;
//            echo $newURL;
        }

        return $newURL;
    }
}