<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Portal\Campaign;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\Libraries\CampaignSelector;

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

        $campaignIndex = count($campaigns) > 1 ? rand(0, count($campaigns) - 1) : 0;

        $campaignSelected = $campaigns->campaign[$campaignIndex];

        $campaignType = "Portal\\Libraries\\Interactions\\" . studly_case($campaignSelected->interaction['name']);
        $interaction = new $campaignType($campaignSelected);

        session(['campaign_id' => $campaignSelected->_id]);

        return view($interaction->getView(), [
            'id' => $campaignSelected->_id,
            'data' => $interaction->getData()
        ]);

    }

    public function saveMail()
    {
        //agarrar token, obtener user, identificar campaña y guardar mail
        return 'guardando correo: ' . session('user_mail')." c_id: ".session('campaign_id');

    }

    /**
     *
     */
    public function prueba()
    {
        $banner = new Banner('55c10856a8269769ac822f9a');
        $banner->getData();
        $vista = $banner->getView();
        return view($vista, ['data' => $banner->getData()]);


    }

    public function pruebaMailing()
    {
        $mailing = new MailingList('55c10856a8269769ac822f9a');
        $mailing->getData();
        $view = $mailing->getView();
        return view($view, ['data' => $mailing->getData()]);
    }

//    public function captcha()
//    {
//        $camp = new CampaignSelector('5609b6ca1065d14cbccedd28');
//        $banner = new Captcha('55f6ee95a8265d9826c506cc');
////        $camp->getData();
////        $vista=$camp->getView();
//        return view($vista, ['data' => $camp->getData()]);
//
//
//    }

    public function captcha()
    {
        $campaign = Campaign::find('55f6ee95a8265d9826c506cc');
        $c = new CampaignSelector('5609b6ca1065d14cbccedd28', '00:18:0a:e8:29:50');
        return view('interaction.captcha', ['captcha' => $campaign->content['captcha'], 'cover' => $campaign->content['cover_path'], 'c' => $c]);
    }

}
