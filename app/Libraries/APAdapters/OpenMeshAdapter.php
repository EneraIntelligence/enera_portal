<?php

namespace Portal\Libraries\APAdapters;

use Portal\Libraries\APAdapters\IAdapter;
use Validator;


class OpenMeshAdapter implements IAdapter
{

    public function processInput($input)
    {
        $openMeshValidator = Validator::make( $input, [
            'res' => 'required',
            'uamip' => 'required',
            'uamport' => 'required',
            'mac' => 'required',
            'called' => 'required',
            'ssid' => 'required',
            'userurl' => 'required',
            'challenge' => 'required',
        ]);



        if ($openMeshValidator->passes())
        {


            if ($input['res'] === "success") 
            {
                $this->redirectToEnera();
                return [];
            }


            //set variables to connect via openmesh server
            $uam_secret = "3n3r41nt3ll1g3nc3";
            $username="test";
            $password = "test";
            $challenge = $input['challenge'];
            
            $encoded_password = $this->encode_password($password, $challenge, $uam_secret);


            $uamip = $input['uamip'];
            $uamport = $input['uamport'];
            
            $redirect_url = "http://$uamip:$uamport/logon?" .
                "username=" . urlencode($username) .
                "&password=" . urlencode($encoded_password);


            $user_url = $input['userurl'];
            
            if(!isset($user_url) || $user_url=="")
            {
                $user_url = "http://enera.mx/";
            }

            $redirect_url .= "&redir=" . urlencode( $user_url );


            $node_mac = $this->formatMac($input['called']);
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


    /*
     * encodes the challenge with the secret for open-mesh login
     */
    private function encode_password($plain, $challenge, $secret) {
        if ((strlen($challenge) % 2) != 0 ||
            strlen($challenge) == 0)
            return FALSE;

        $hexchall = hex2bin($challenge);
        if ($hexchall === FALSE)
            return FALSE;

        if (strlen($secret) > 0) {
            $crypt_secret = md5($hexchall . $secret, TRUE);
            $len_secret = 16;
        } else {
            $crypt_secret = $hexchall;
            $len_secret = strlen($hexchall);
        }

        /* simulate C style \0 terminated string */
        $plain .= "\x00";
        $crypted = '';
        for ($i = 0; $i < strlen($plain); $i++)
            $crypted .= $plain[$i] ^ $crypt_secret[$i % $len_secret];

        $extra_bytes = 0;//rand(0, 16);
        for ($i = 0; $i < $extra_bytes; $i++)
            $crypted .= chr(rand(0, 255));

        return bin2hex($crypted);
    }

    

    private function redirectToEnera()
    {
        $redir = "http://enera.mx";
        if(isset($redir)) {
            echo "<head>";
            echo '<meta http-equiv="refresh" content="3;URL=\'' . $redir . '\'">';
            echo "</head>";
        }
        else {
            echo "<h2>Log-in successful!</h2>";
        }

    }
}