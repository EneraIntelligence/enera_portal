<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\Libraries\CampaignSelector;
use Portal\Libraries\Interactions\Banner;
use Portal\Libraries\Interactions\MailingList;

class CampaignsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $campaigns = new CampaignSelector($user_id);

        $numCampaigns = count($campaigns);

        $campaignIndex = rand ( 0 , $numCampaigns-1 );

        //eliminar esto de abajo
        $campaignIndex=2;

        $campaignType = $campaigns->campaign[$campaignIndex]->interaction['name'];
        $campaignType = strtolower($campaignType);
        $campaignData = $campaigns->campaign[$campaignIndex]['original'];

        //dd($campaignData);

        $interaction=null;
        switch($campaignType)
        {
            case "banner":
                $interaction = new Banner($campaignData);
                break;
            case "mailinglist":
                $interaction = new MailingList($campaignData);
                break;
        }

        return view($interaction->getView(), ['data' => $interaction->getData()]);

    }

    /**
     *
     */
    public function prueba()
    {
        $banner = new Banner('55c10856a8269769ac822f9a');
        $banner->getData();
        $vista=$banner->getView();
        return view($vista, ['data' => $banner->getData()]);


    }

    public function pruebaMailing()
    {
        $mailing = new MailingList('55c10856a8269769ac822f9a');
        $mailing->getData();
        $view=$mailing->getView();
        return view($view, ['data' => $mailing->getData()]);
    }
}
