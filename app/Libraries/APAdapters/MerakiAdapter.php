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

}