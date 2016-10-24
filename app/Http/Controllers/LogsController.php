<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;

use Jenssegers\Agent\Agent;
use MongoDate;
use Portal\Branche;
use Portal\CampaignLog;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;

class LogsController extends Controller
{
    public function welcome()
    {
        if (!session('client_mac'))
        {
            $response = [
                'ok' => false,
                'msg' => 'Welcome::No client MAC Address',
            ];


            return response()->json($response);
        }


        $client_mac = session('client_mac');
        $log = CampaignLog::where('user.session', session('_token'))
            ->where('device.mac', $client_mac)->first();

        if ($log)
        {
            $response = [
                'ok' => true,
                'msg' => 'log already created'
            ];
            
        } else
        {

            $agent = new Agent();
            $node_mac = session('node_mac');

            //no existe log, creando
            $new_log = CampaignLog::create([
                'user' => [
                    'session' => session('_token')
                ],
                'device' => [
                    'mac' => $client_mac,
                    'node_mac' => $node_mac,
                    'os' => $agent->platform(),
                    'branch_id' => Branche::whereIn('aps', [$node_mac])->first()->_id,
                ]
            ]);

            //se introduce la info de welcome
            $new_log->interaction()->create([
                'welcome' => new MongoDate(),
            ]);

            $response = [
                'ok' => true,
                'msg' => 'New welcome log created',
            ];
        }


        return response()->json($response);

    }

    public function welcome_loaded()
    {
        if (!session('client_mac'))
        {
            $response = [
                'ok' => false,
                'msg' => 'Welcome_loaded::No client MAC Address',
            ];


            return response()->json($response);
        }


        $client_mac = session('client_mac');
        $log = CampaignLog::where('user.session', session('_token'))
            ->where('device.mac', $client_mac)->first();

        if ($log)
        {
        
            $log->interaction->welcome_loaded = new MongoDate();
            $log->interaction->save();
        
            $response = [
                'ok' => true,
                'msg' => 'welcome_loaded',
            ];
        } else
        {
            $response = [
                'ok' => false,
                'msg' => 'welcome_loaded::no log found'
            ];
            
        }

        return response()->json($response);

    }


    public function joined()
    {
        if (!session('client_mac'))
        {
            $response = [
                'ok' => false,
                'msg' => 'Joined::No client MAC Address',
            ];


            return response()->json($response);
        }


        $client_mac = session('client_mac');
        $log = CampaignLog::where('user.session', session('_token'))
            ->where('device.mac', $client_mac)->first();

        if ($log)
        {

            $log->interaction->joined = new MongoDate();
            $log->interaction->save();

            $response = [
                'ok' => true,
                'msg' => 'joined',
            ];
        } else
        {
            $response = [
                'ok' => false,
                'msg' => 'Joined::no log found'
            ];

        }

        return response()->json($response);

    }

    public function requested()
    {
        if (!session('client_mac'))
        {
            $response = [
                'ok' => false,
                'msg' => 'Requested::No client MAC Address',
            ];


            return response()->json($response);
        }


        $client_mac = session('client_mac');
        $log = CampaignLog::where('user.session', session('_token'))
            ->where('device.mac', $client_mac)->first();

        if ($log)
        {

            $log->interaction->requested = new MongoDate();
            $log->interaction->save();

            $response = [
                'ok' => true,
                'msg' => 'requested',
            ];
        } else
        {
            $response = [
                'ok' => false,
                'msg' => 'Requested::no log found'
            ];

        }

        return response()->json($response);

    }

    public function loaded()
    {
        if (!session('client_mac'))
        {
            $response = [
                'ok' => false,
                'msg' => 'Loaded::No client MAC Address',
            ];


            return response()->json($response);
        }


        $client_mac = session('client_mac');
        $log = CampaignLog::where('user.session', session('_token'))
            ->where('device.mac', $client_mac)->first();

        if ($log)
        {

            $log->interaction->loaded = new MongoDate();
            $log->interaction->save();

            $response = [
                'ok' => true,
                'msg' => 'loaded',
            ];
        } else
        {
            $response = [
                'ok' => false,
                'msg' => 'Loaded::no log found'
            ];

        }

        return response()->json($response);

    }


    public function completed()
    {
        if (!session('client_mac'))
        {
            $response = [
                'ok' => false,
                'msg' => 'Completed::No client MAC Address',
            ];


            return response()->json($response);
        }


        $client_mac = session('client_mac');
        $log = CampaignLog::where('user.session', session('_token'))
            ->where('device.mac', $client_mac)->first();

        if ($log)
        {

            $log->interaction->completed = new MongoDate();
            $log->interaction->save();

            $response = [
                'ok' => true,
                'msg' => 'completed',
            ];
        } else
        {
            $response = [
                'ok' => false,
                'msg' => 'Completed::no log found'
            ];

        }

        return response()->json($response);

    }

}
