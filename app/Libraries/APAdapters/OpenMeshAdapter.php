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


            if ($input['res'] === "success") {

                $redir = "http://enera.mx";
                if(isset($redir)) {
                    echo "<head>";
                    echo '<meta http-equiv="refresh" content="3;URL=\'' . $redir . '\'">';
                    echo "</head>";
                }
                else {
                    echo "<h2>Log-in successful!</h2>";
                }

                return [];
            }


            //connected via openmesh
            $uam_secret = "3n3r41nt3ll1g3nc3";

            $username="test";
            $password = "test";
            $uamip = $input['uamip'];
            $uamport = $input['uamport'];
            $challenge = $input['challenge'];
            $user_url = $input['userurl'];

            $node_mac = $this->formatMac($input['called']);
            $client_mac =  $this->formatMac($input['mac']);


            $encoded_password = $this->encode_password($password, $challenge, $uam_secret);

            $redirect_url = "http://$uamip:$uamport/logon?" .
                "username=" . urlencode($username) .
                "&password=" . urlencode($encoded_password);

            if(!isset($user_url) || $user_url=="")
            {
                $user_url = "http://enera.mx/";
            }

            $redirect_url .= "&redir=" . urlencode( $user_url );


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

    public function addVars($url, $vars)
    {
        $first = true;

        if (strpos($url, '?') !== FALSE)
            $first=false;

        foreach ($vars as $key => $value) {
            if($first)
            {
                $first=false;
                $url = '?'.$url.urlencode( $key ) .'='. urlencode($value);
            }
            else
            {
                $url = '&'.$url.urlencode( $key ) .'='. urlencode($value);
            }
        }
        return $url;
    }

    private function formatMac($mac)
    {
        $res = strtolower($mac);
        return str_replace("-", ":", $res);
    }

    /**
     * decode_password - decode encoded password to ascii string
     * @dict: dictionary containing request RA
     * @encoded: The encoded password
     * @secret: Shared secret between node and server
     *
     * Returns decoded password or FALSE on error
     */
    private function decode_password($dict, $encoded, $secret)
    {
        if (!array_key_exists('RA', $dict))
            return FALSE;
        if (strlen($dict['RA']) != 32)
            return FALSE;
        $ra = hex2bin($dict['RA']);
        if ($ra === FALSE)
            return FALSE;
        if ((strlen($encoded) % 32) != 0)
            return FALSE;
        $bincoded = hex2bin($encoded);
        $password = "";
        $last_result = $ra;
        for ($i = 0; $i < strlen($bincoded); $i += 16) {
            $key = hash('md5', $secret . $last_result, TRUE);
            for ($j = 0; $j < 16; $j++)
                $password .= $key[$j] ^ $bincoded[$i + $j];
            $last_result = substr($bincoded, $i, 16);
        }
        $j = 0;
        for ($i = strlen($password); $i > 0; $i--) {
            if ($password[$i - 1] != "\x00")
                break;
            else
                $j++;
        }
        if ($j > 0) {
            $password = substr($password, 0, strlen($password) - $j);
        }

        return $password;
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

}