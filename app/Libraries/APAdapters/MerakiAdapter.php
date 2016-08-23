<?php

namespace Portal\Libraries\APAdapters;

use Portal\Libraries\APAdapters\IAdapter;

class MerakiAdapter implements IAdapter
{

    public function processInput($input)
    {
        //return data as is
        return $input;
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
        echo $newURL;
        if(strpos($url,'network-auth.com')!==false)
        {
            echo 'la url esta vacia';
            $newURL=$defaultURL;
            echo $newURL;
        }

        return $newURL;
    }
}