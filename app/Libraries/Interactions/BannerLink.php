<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:35 AM
 */

namespace Portal\Libraries\Interactions;

use Portal\Libraries\Enera;
use Portal\Campaign;

class BannerLink extends Enera
{

    protected $data;
    // $id_campaign = '55c10856a8269769ac822f9a';
    protected $campaign;

    /**
     * Banner constructor.
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->view = "interaction.bannerLink";
        $this->campaign = $campaign;
        //var_dump($this->campaign);
    }

    public function getLink()
    {
        return $this->campaign->content['banner_link'];
    }
}