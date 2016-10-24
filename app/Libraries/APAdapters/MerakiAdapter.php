<?php

namespace Portal\Libraries\APAdapters;

use Portal\Libraries\APAdapters\IAdapter;
use Validator;

class MerakiAdapter implements IAdapter
{

    public function processInput($input)
    {
        $validate = Validator::make($input, [
            'base_grant_url' => 'required',
            'user_continue_url' => 'required',
            'node_mac' => 'required',
            'client_mac' => 'required'
        ]);

        if($validate->passes())
        {
            //return data as is
            return $input;
        }
        
        return null;
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