<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use MongoDate;
use Portal\Campaign;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\CampaignLog;
use Portal\Jobs\EmailEndJob;
use Session;
use Validator;
use Portal\Interaction;

class InteractionsController extends Controller
{
    protected $token;
    protected $fecha;
    protected $mac;

    public function __construct()
    {
        $this->token = session('_token');
        $this->fecha = new MongoDate();
    }

    public function welcome()
    {
        // in WelcomeLogJob
    }

    /**
     *
     */
    public function joined()
    {
        $validate = Validator::make(Input::all(), [
            'client_mac' => 'required'
        ]);
        if ($validate->passes()) {
            $log = CampaignLog::where('user.session', $this->token)
                ->where('device.mac', Input::get('client_mac'))->first();
            if ($log && !isset($log->interaction->joined)) {
                if (!isset($log->interaction->welcome)) {
                    $log->interaction()->create([
                        'welcome' => $this->welcome,
                        'joined' => new MongoDate(),
                    ]);
                } else {
                    $log->interaction->joined = new MongoDate();
                    $log->interaction->save();
                }
                $response = ['ok' => true];
            } else {
                $response = [
                    'ok' => false,
                    'step' => 'Update log'
                ];
            }
        } else {
            $response = [
                'ok' => false,
                'step' => 'Validate vars'
            ];
        }
        return response()->json($response);
    }

    /**
     * @return array
     */
    public function requested()
    {
        // in RequestedLogJob
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function loaded()
    {
        $log = CampaignLog::where('user.session', $this->token)
            ->where('device.mac', Input::get('client_mac'))->first();
        if ($log && !isset($log->interaction->loaded)) {
            $log->interaction->loaded = $this->fecha;
            $log->interaction->save();
            $response = ['ok' => true];
        } else {
            $response = [
                'ok' => false,
                'step' => 'Update log-loaded'
            ];
        }
        return response()->json($response);
    }

    public function completed()
    {
        $log = CampaignLog::where('user.session', $this->token)
            ->where('device.mac', Input::get('client_mac'))->first();

        if ($log && !isset($log->interaction->completed) && isset($log->campaign_id)) {
            //campaign found and completed

            //Monetization
            $campaign = $log->campaign;
            $balanceBefore = floatval($campaign->balance['current']);

            $interactionAmount = floatval($campaign->interaction['price']);
            $interactionMultiplier = floatval(1);
            $interactionTotal = floatval($interactionAmount * $interactionMultiplier);

            //decrement amount on current balance
            Campaign::where('_id', $log->campaign_id)->decrement('balance.current', $interactionTotal);
            $campaignDecremented = Campaign::where('_id', $log->campaign_id)->first();

            $balanceAfter = floatval($campaignDecremented->balance['current']);

            //save log
            $log->interaction->completed = $this->fecha;

            $log->cost = array();
            $log->cost['balance_before'] = $balanceBefore;
            $log->cost['balance_after'] = $balanceAfter;
            $log->cost['base'] = $interactionAmount;
            $log->cost['multiplier'] = $interactionMultiplier;
            $log->cost['amount'] = $interactionTotal;

            $log->cost->save();
            $log->interaction->save();

            if ($balanceAfter - $interactionTotal <= 0) {
                //campaign out of funds
                $this->endCampaign($campaignDecremented);
            }

            $response = ['ok' => true];

            $this->accessed();

            Session::flush();
            Session::regenerate();

        } else {
            $response = [
                'ok' => false,
                'step' => 'Update log-completed',
                'error' => 'The log was not found or it was already completed'
            ];
        }
        return response()->json($response);
    }

    public function accessed()
    {
        $log = CampaignLog::where('user.session', $this->token)
            ->where('device.mac', Input::get('client_mac'))->first();

        if ($log && !isset($log->interaction->accessed) ) {

            //save log
            $log->interaction->accessed = $this->fecha;

            $log->interaction->save();

            $response = ['ok' => true];

        } else {
            $response = [
                'ok' => false,
                'step' => 'Update log-accessed',
                'error' => 'The log was not found or it was already marked as accessed'
            ];
        }
        return response()->json($response);
    }

    /**
     * Guarda las respuesta de la encuesta
     */
    public function saveUserSurvey()
    {
        $answers = Input::get("answers");

        $log = CampaignLog::where('user.session', $this->token)
            ->where('device.mac', Input::get('client_mac'))->push('survey', $answers,true);

        $response = ['ok' => true];
        return $response;

    }

    /**
     * @param $campaign
     */
    private function endCampaign($campaign)
    {
        //end campaign because it has no funds
        $log = array();
        $log['administrator_id'] = "user_interaction";
        $log['status'] = "ended";
        $log['note'] = "Campaña finalizada por falta de fondos";

        $campaign->status = 'ended';
        $campaign->save();

        $campaign->history()->create($log);
        $this->dispatch(new EmailEndJob($log['administrator_id']));
    }
}

