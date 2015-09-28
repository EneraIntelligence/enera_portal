<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:25 AM
 */

namespace Portal\Libraries\Interactions;


use Portal\Libraries\Enera;

class Banner extends Enera
{
    protected $data;

    public function __construct()
    {
        $this->view = "interactions.banner";
    }
}