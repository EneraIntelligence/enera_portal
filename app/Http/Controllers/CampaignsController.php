<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Portal\Campaign;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\Jobs\RequestedLogJob;
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

        $this->dispatch(new RequestedLogJob([
            'session' => session('_token'),
            'client_mac' => Input::get('client_mac'),
            'campaign_id' => $campaignSelected->_id
        ]));

        return view($interaction->getView(), [
            'id' => $campaignSelected->_id,
            'data' => $interaction->getData()
        ]);

    }

    public function saveMail()
    {
        //agarrar token, obtener user, identificar campaña y guardar mail
        //return 'guardando correo: ' . session('user_mail')." c_id: ".session('campaign_id');

        //$addToSet
        $campaign = Campaign::where('_id',session('campaign_id'));
        //dd($campaign);

        if(!isset($campaign->mailing_list))
            $campaign->mailing_list = [];

        $campaign->mailing_list[] = session('user_email');
        $campaign->save();


        //redirect(campaign->link);
        return 'email saved'.session('user_email').' on campaign with id: '.session('campaign_id');
        //dd($campaign);
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
