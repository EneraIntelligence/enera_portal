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

    protected $view;
    protected $data;
    protected $campaign;

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->campaign->content;
    }

}