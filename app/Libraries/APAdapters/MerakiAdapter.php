<?php

namespace Portal\Libraries\APAdapters;

use Portal\Libraries\APAdapters\IAdapter;

class MerakiAdapter implements IAdapter
{

    public function processInput($input)
    {
        //return data as is
        if(strpos($input['user_continue_url'],'network-auth.com')===false)
        {
            $input['user_continue_url']="";
        }
        return $input;
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
                $url = $url.'?'.urlencode( $key ) .'='. urlencode($value);
            }
            else
            {
                $url = $url.'&'.urlencode( $key ) .'='. urlencode($value);
            }
        }
        return $url;
    }

}