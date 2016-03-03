<?php

namespace Portal\Libraries\APAdapters;


interface IAdapter
{
    public function processInput($input);
    public function addVars($url, $vars);
    public function validateUserContinueURL($url, $defaultURL);
}