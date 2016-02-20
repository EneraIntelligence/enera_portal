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
}