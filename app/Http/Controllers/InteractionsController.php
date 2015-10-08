<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use MongoDate;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\CampaignLog;
use Validator;

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
                $log->interaction->joined = new MongoDate();
                $log->interaction->save();
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
        }else {
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

        if ($log && !isset($log->interaction->completed)) {
            $log->interaction->completed = $this->fecha;
            $log->interaction->save();
            $response = ['ok' => true];
        }else {
            $response = [
                'ok' => false,
                'step' => 'Update log-completed'
            ];
        }
        return response()->json($response);
    }
}

/*$response = [
            'default' => false,
            'step' => 'default log-loaded'
        ];*/
