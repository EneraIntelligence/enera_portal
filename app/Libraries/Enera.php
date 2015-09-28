<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:23 AM
 */

namespace Portal\Libraries;


class Enera
{
//    protected $_data = ['view'];
    protected $view;

    public function __construct()
    {

    }

    public function getView()
    {
        return $this->view;
    }

    public function getData()
    {
        return $this->data;
    }
}