<?php

namespace Portal\Libraries\APAdapters;


interface IAdapter
{
    public function processInput($input);
    public function addVars($url, $vars);
}