<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:25 AM
 */

namespace Portal\Libraries\Interactions;

use Portal\Libraries\Enera;
use Portal\Campaign;

class Iframe extends Enera
{
    protected $data;
    protected $campaign;

    /**
     * Banner constructor.
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->view = "interaction.iframe";
        $this->campaign = $campaign;
        //var_dump($this->campaign);
    }

    public function getLink()
    {
        return $this->campaign->content['link'];
    }

}