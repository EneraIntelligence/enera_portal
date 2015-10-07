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


    public function __construct($id_camp)
    {
        $this->view = "/interaction/captcha";
        $this->id_campaign = $id_camp;
    }

    public function getData()
    {
        $captcha = Campaign::where('_id', $this->id_campaign)->first();
        $content = $captcha->content;
        $this->data['captcha'] = $content['captcha'];
        $this->data['image_path'] = $content['image_path'];

        return $this->data;
    }
}