<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Jenssegers\Agent\Agent;
use Portal\Branche;
use Portal\Campaign;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\Jobs\RequestedLogJob;
use Portal\Jobs\SendFirstMailJob;
use Portal\Libraries\CampaignSelector;
use Portal\User;

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
        $user = User::find($user_id);
        if ($user) {
            $campaigns = new CampaignSelector($user_id);

            if (count($campaigns->campaign) == 0) {
                //default campaign
                $campaignSelected = new Campaign();
                $campaignSelected->_id = "default";
                $campaignSelected->content = array();

                $campaignType = "Portal\\Libraries\\Interactions\\FacePas";
                $interaction = new $campaignType($campaignSelected);

                $this->dispatch(new RequestedLogJob([
                    'session' => session('_token'),
                    'client_mac' => Input::get('client_mac'),
                    'campaign_id' => $campaignSelected->_id,
                    'user_id' => $user_id
                ]));
            /**    saco el link de la branch buscando la branch con la mac del ap  **/
                $branch = Branche::whereIn('aps', [Input::get('node_mac')])->first();
                $link = isset($branch->portal['default_url'])?$branch->portal['default_url']:'http://www.enera.mx';
                return view($interaction->getView(),['link'=>$link]);
            } else {
                //choose random campaign
                $campaignIndex = count($campaigns->campaign) > 1 ? rand(0, count($campaigns) - 1) : 0;

                $campaignSelected = $campaigns->campaign[$campaignIndex];

                $campaignType = "Portal\\Libraries\\Interactions\\" . studly_case($campaignSelected->interaction['name']);
                $interaction = new $campaignType($campaignSelected);

                session(['campaign_id' => $campaignSelected->_id]);

                $this->dispatch(new RequestedLogJob([
                    'session' => session('_token'),
                    'client_mac' => Input::get('client_mac'),
                    'campaign_id' => $campaignSelected->_id,
                    'user_id' => $user_id
                ]));

                return view($interaction->getView(), array_merge(['_id' => $campaignSelected->_id], $interaction->getData()));
            }
        } else {
            return redirect()->route('welcome');
        }
    }

    /**
     * Identifica campaña y hace push del email
     * @return array
     */
    public function saveMail()
    {
        $camp = Campaign::find(session('campaign_id'));
        $user = User::find(session('user_id'));

        $camp->push('mailing_list', session('user_email'), true);

        $this->dispatch(new SendFirstMailJob($camp, $user));
        $response = ['ok' => true];
        return $response;
    }

    /**
     * Identifica campaña y hace push del email
     * @return array
     */
    public function saveUserLike()
    {
        Campaign::where('_id', session('campaign_id'))->push('user_likes', session('user_fbid'), true);
        $response = ['ok' => true];
        return $response;
    }


}
