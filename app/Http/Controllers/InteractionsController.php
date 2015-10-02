<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\CampaignLog;

class InteractionsController extends Controller
{
    public function welcome()
    {

    }

    public function joined()
    {

    }

    /**
     * @return array
     */
    public function requested(  )
    {

//        return Request::all();
//        return $data;
//        Request::getTrustedHeaderName(link());
        return \Request::all();
        /*if(Request::all()) {
            $data = Input::all();
            print_r($data);
            return $data;
        }*/

        /*$camplog = new CampaignLog([
            'user' => [
                'session' => session('_token')
            ],
            'device' => [
                'mac' => Input::get('node_mac')
            ],
            'interaction' => [
                'welcome' => new MongoDate()
            ]
        ]);
        $camplog->save();*/

    }

    public function loaded()
    {
        /*$camplog = new CampaignLog([
            'user' => [
                'session' => session('_token')
            ],
            'device' => [
                'mac' => Input::get('node_mac')
            ],
            'interaction' => [
                'welcome' => new MongoDate()
            ]
        ]);
        $camplog->save();*/
        return \Request::all();
//        return true;
    }

    public function completed()
    {

    }
}
