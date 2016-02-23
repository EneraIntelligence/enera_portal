<?php

namespace Portal\Libraries\APAdapters;

use Portal\Libraries\APAdapters\IAdapter;

class DefaultAdapter implements IAdapter
{

    public function processInput($input)
    {
        //return empty so it goes to invalid network
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
                $url = $url.urlencode( '?'.$key.'='.$value );
            }
            else
            {
                $url = $url.urlencode( '&'.$key.'='.$value );
            }
        }
        return $url;
    }
}