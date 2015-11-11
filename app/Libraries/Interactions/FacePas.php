<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 11/11/15
 * Time: 10:07 AM
 */

namespace Portal\Libraries\Interactions;

use Portal\Libraries\Enera;
use Portal\Campaign;

class FacePas extends Enera
{
    protected $data;
    protected $campaign;

    /**
     * Banner constructor.
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->view = "interaction.facePas";
        $this->campaign = $campaign;
//        dd($this->campaign);
//        {{--susses_url="{{Input::get('base_grant_url').'?continue_url=http://'.$link.'&duration=900' }}"--}}
//        redirect()->to( Input::get('base_grant_url').'?continue_url=http://'.$campaign['content']['link'].'&duration=900');
    }

    public function getLink()
    {
        return $this->campaign->content['link'];
    }

}