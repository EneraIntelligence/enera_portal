<?php

namespace Portal\Http\Controllers;


use Portal\Http\Requests;
use Session;


class OpenMeshController extends Controller
{


    public function openMeshAuth()
    {
        /**
         * secret - Shared secret between server and node
         */
        $secret = "3n3r41nt3ll1g3nc3";
        /**
         * response - Standard response (is modified depending on the result
         */
        $response = array(
            'CODE' => 'REJECT',
            'RA' => '0123456789abcdef0123456789abcdef',
            'BLOCKED_MSG' => 'Rejected! This doesnt look like a valid request',
        );

        /* copy request authenticator */
        if (array_key_exists('ra', $_GET) && strlen($_GET['ra']) == 32 && ($ra = hex2bin($_GET['ra'])) !== FALSE && strlen($ra) == 16)
        {
            $response['RA'] = $_GET['ra'];
        }

        /* decode password when available */
        $password = FALSE;
        if (array_key_exists('username', $_GET) && array_key_exists('password', $_GET))
            $password = $this->decode_password($response, $_GET['password'], $secret);

        /* store mac when available */
        $mac = FALSE;
        if (array_key_exists('mac', $_GET))
            $mac = $_GET['mac'];

        $duration = 900;
        if (array_key_exists('duration', $_GET))
            $duration = $_GET['duration'];

        if (Session::has('session_time'))
        {
            $duration = session('session_time');
        }

        /* decode request */
        if (array_key_exists('type', $_GET))
        {
            $type = $_GET['type'];
            switch ($type)
            {
                case 'login':
                    if ($password === FALSE)
                        break;
                    if ($password == 'test' && $_GET['username'] == 'test')
                    {
                        unset($response['BLOCKED_MSG']);
                        $response['CODE'] = "ACCEPT";
                        $response['SECONDS'] = $duration;
                        $response['DOWNLOAD'] = 2000;
                        $response['UPLOAD'] = 800;
                    } else
                    {
                        $response['BLOCKED_MSG'] = "Invalid username or password";
                    }
                    break;
            };
        }


        /* calculate new request authenticator based on answer and request -> send it out */
        $this->calculate_new_ra($response, $secret);
        $this->print_dictionary($response);

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
        for ($i = 0; $i < strlen($bincoded); $i += 16)
        {
            $key = hash('md5', $secret . $last_result, TRUE);
            for ($j = 0; $j < 16; $j++)
                $password .= $key[$j] ^ $bincoded[$i + $j];
            $last_result = substr($bincoded, $i, 16);
        }
        $j = 0;
        for ($i = strlen($password); $i > 0; $i--)
        {
            if ($password[$i - 1] != "\x00")
                break;
            else
                $j++;
        }
        if ($j > 0)
        {
            $password = substr($password, 0, strlen($password) - $j);
        }

        return $password;
    }


    /*
     * FUNCIONES AUXILIARES OPEN-MESH
     */
    /**
     * print_dictionary - Print dictionary as encoded key-value pairs
     * @dict: Dictionary to print
     */
    private function print_dictionary($dict)
    {
        foreach ($dict as $key => $value)
        {
            echo '"', rawurlencode($key), '" "', rawurlencode($value), "\"\n";
        }
    }

    /**
     * calculate_new_ra - calculate new request authenticator based on old ra, code
     *  and secret
     * @dict: Dictionary containing old ra and code. new ra is directly stored in it
     * @secret: Shared secret between node and server
     */
    private function calculate_new_ra(&$dict, $secret)
    {
        if (!array_key_exists('CODE', $dict))
            return;
        $code = $dict['CODE'];
        if (!array_key_exists('RA', $dict))
            return;
        if (strlen($dict['RA']) != 32)
            return;
        $ra = hex2bin($dict['RA']);
        if ($ra === FALSE)
            return;

        $dict['RA'] = hash('md5', $code . $ra . $secret);
    }
    
}