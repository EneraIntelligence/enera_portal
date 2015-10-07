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

    public function __construct()
    {
        $this->token = session('_token');
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
            if ($log && !isset($log->interaction['joined'])) {
                $log->update(['interaction' => ['joined' => new MongoDate()]]);
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

    public function loaded()
    {
        $camplog = new CampaignLog([
            'user' => [
                'session' => session('_token')
            ],
            'device' => [
                'mac' => "test mac xD"//Input::get('node_mac')
            ],
            'interaction' => [
                'welcome' => new MongoDate()
            ]
        ]);

        $camplog->save();

        return \Request::all();
//        return true;
    }

    public function completed()
    {

    }
}
