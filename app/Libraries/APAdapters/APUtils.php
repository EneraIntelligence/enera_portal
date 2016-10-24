<?php

namespace Portal\Libraries\APAdapters;

class APUtils
{

    public static function getAPAdapter($input)
    {
        if (isset($input['base_grant_url']))
        {
            return new MerakiAdapter();
        } else if (isset($input['res']))
        {
            return new OpenMeshAdapter();
        } else if (isset($input['sip']))
        {
            return new RuckusAdapter();
        } else if (isset($input['switch_url']))
        {
            return new CiscoAdapter();
        }else if (isset($input['apname']))
        {
            return new ArubaAdapter();
        }

        return null;
    }
}