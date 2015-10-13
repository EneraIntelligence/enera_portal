<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:37 AM
 */

namespace Portal\Libraries\Interactions;

use Portal\Campaign;
use Portal\Libraries\Enera;

class Captcha extends Enera
{
    protected $data;
    protected $campaign;


    public function __construct(Campaign $campaign)
    {
        $this->view = "interaction.captcha";
        $this->campaign = $campaign;
    }

}