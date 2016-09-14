<?php

namespace Portal\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Input;
use Jenssegers\Agent\Agent;
use Mail;
use MongoDate;
use Portal\Branche;
use Portal\Campaign;
use Portal\CampaignLog;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\Jobs\RequestedLogJob;
use Portal\Jobs\SendFirstMailJob;
use Portal\Libraries\CampaignSelector;
use Portal\User;
use Session;
use URL;



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
        $link = '';
        $user = User::find($user_id);
        $log = CampaignLog::where('user.session', session('_token'))
            ->where('interaction.welcome', 'exists', true)
            ->where('interaction.accessed', 'exists', false)->count();

        if ( isset($user) && $log >= 1) {
            $campaigns = new CampaignSelector($user_id);
            /**    valida que el user_continue_url tenga algo   **/
            if (Input::has('user_continue_url') || Input::get('user_continue_url') != '') {
//                echo 'entro a diferente';
                if (Input::get('user_continue_url') == "''") {
                    $link['link'] = 'http://www.google.com';
                } else {
                    $link['link'] = Input::get('user_continue_url');
                }
            } else {
                /**    saco el link de la branch buscando la branch con la mac del ap  **/
//                echo 'entro a vacio';
                $branch = Branche::whereIn('aps', [Input::get('node_mac')])->first();
                $link['link'] = isset($branch->portal['default_url']) ? $branch->portal['default_url'] : 'http://www.google.com';
            }

            if (count($campaigns->campaign) == 0) {
                
                //default campaign
                
                //fake campaign
                $campaignSelected = new Campaign();
                $campaignSelected->_id = "default";
                $campaignSelected->content = array();

                //facepas
//              $campaignType = "Portal\\Libraries\\Interactions\\FacePas";
                $campaignType = "Portal\\Libraries\\Interactions\\BrandCaptcha";
                $interaction = new $campaignType($campaignSelected);

                /*$this->dispatch(new RequestedLogJob([
                    'session' => session('_token'),
                    'client_mac' => Input::get('client_mac'),
                    'campaign_id' => $campaignSelected->_id,
                    'user_id' => $user_id
                ]));*/


                session([
                    'success_redirect_url' =>  URL::route('ads')
                ]);
                
                $this->requested([
                    'session' => session('_token'),
                    'client_mac' => Input::get('client_mac'),
                    'campaign_id' => $campaignSelected->_id,
                    'user_id' => $user_id
                ]);
                return view($interaction->getView(), $link);
            } else {
                //choose random campaign
                $campaignIndex = count($campaigns->campaign) > 1 ? rand(0, count($campaigns->campaign) - 1) : 0;

                $campaignSelected = $campaigns->campaign[$campaignIndex];

                $campaignType = "Portal\\Libraries\\Interactions\\" . studly_case($campaignSelected->interaction['name']);
                $interaction = new $campaignType($campaignSelected);

                session([
                    'campaign_id' => $campaignSelected->_id,
                    'user_id' => $user->_id,
                ]);

                $this->requested([
                    'session' => session('_token'),
                    'client_mac' => Input::get('client_mac'),
                    'campaign_id' => $campaignSelected->_id,
                    'user_id' => $user_id
                ]);

                session([
                    'success_redirect_url' =>  $link
                ]);

                return view($interaction->getView(), $link, array_merge(
                    ['_id' => $campaignSelected->_id],
                    $interaction->getData(),
                    ['fb_id'=>session('user_fbid')]
                    ));
            }
        } else {
            return redirect()->route('welcome', Input::all());
        }
    }

    private function requested($data)
    {
        // Paso 3: Registered log
        $log = CampaignLog::where('user.session', $data['session'])
            ->where('device.mac', $data['client_mac'])->first();

        if ($log) {
            $log->campaign_id = $data['campaign_id'];
            $user = User::find($data['user_id']);
            $u['id'] = $user->_id;
            $u['gender'] = $user->facebook->gender;
            /**/
            $birthday = new DateTime($user->facebook->birthday['date']);
            $today = date('Y-m-d');
            $age = $birthday->diff(new DateTime($today));
            /**/
            $u['age'] = $age->y;
            $u['session'] = $data['session'];
            $log->user = $u;
            $log->save();

            if (!isset($log->interaction->requested)) {
                $log->interaction->requested = new MongoDate();
                $log->interaction->save();
            }
        }
    }

    /**
     * Identifica campaña y hace push del email
     * @return array
     */
    public function saveMail()
    {
        if (Session::has('campaign_id') && Session::has('user_id')) {

            $camp = Campaign::find(session('campaign_id'));
            $user = User::find(session('user_id'));

            if ($user && $camp) {
                $camp->push('mailing_list', session('user_email'), true);

                /*$this->dispatch(new SendFirstMailJob($camp, $user));*/
                //
                Mail::send('mail.generic', ['content' => $camp->content['mail']['content']], function ($mail) use ($user, $camp) {
                    $mail->from($camp->content['mail']['from_mail'], $camp->content['mail']['from_name']);
                    $mail->to($user->facebook->email, $user->facebook->first_name)->subject($camp->content['mail']['subject']);
                });
                //
                $response = ['ok' => true];
            } else {
                $response = ['ok' => false];
            }

        } else {
            $response = ['ok' => false];
        }

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
