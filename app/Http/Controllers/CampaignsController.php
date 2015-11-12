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

        return view($interaction->getView(), array_merge(['_id' => $campaignSelected->_id], $interaction->getData()));

    }

    /**
     * @return array
     */
    public function saveMail()
    {
        //identifica campaña y hace push del email
        Campaign::where('_id', session('campaign_id'))->push('mailing_list', session('user_email'), true);
        $response = ['ok' => true];
        return $response;
//        return 'email saved '.session('user_email').' on campaign with id: '.session('campaign_id');
    }

    /**
     * Guarda las respuesta de la encuenta
     */
    public function save_survey()
    {
        //
    }

}
