<?php

namespace Portal\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Input;
use MongoDate;
use Portal\Branche;
use Portal\Campaign;
use Portal\CampaignLog;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\InputLog;
use Portal\Libraries\APAdapters\APUtils;
use Portal\Libraries\CampaignSelector;
use Portal\Libraries\NewCampaignSelector;
use Portal\User;

class PortalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        dd(url('grant_access'));

        $rawInput = Input::all();

        if (env('APP_ENV') == 'local') {
            //simulating input for testing
            $rawInput['node_mac'] = "ac:86:74:50:48:e0";//concentro branch
            $rawInput['base_grant_url'] = 'http://ederdiaz.com';
            $rawInput['user_continue_url'] = 'http://ederdiaz.com';
            $rawInput['client_mac'] = 'c0:ee:fb:21:55:fb';
        }

        //detecta marca de ap y asigna un adaptador
        $inputAdapter = APUtils::getAPAdapter($rawInput);

        if ($inputAdapter == null) {
            $this->saveInputLog($rawInput);
            return $this->invalidNetworkView();
        }
        //ajusta los inputs al estandar de enera
        $input = $inputAdapter->processInput($rawInput);
        session($input);
        $client_mac = $rawInput['client_mac'];

        $user = User::where('facebook.id', 'exists', true)
            ->whereIn('devices.mac', [$client_mac])
            ->first();
        
        if (!isset($user))
            $campaignSelection = NewCampaignSelector::allUsers()->all();
        else
            $campaignSelection = NewCampaignSelector::facebookUsers($user['_id']);

        $count = count($campaignSelection->all());
        if ($count > 0) {
            $campaign = $campaignSelection->all()[rand(0, $count - 1)];
        } else {
            $campaign = Campaign::where('_id', '5720fe8dc09c2fe0040041ac')->first();
        }
        session(['campaign_id' => $campaign['_id']]);
        return view('welcome.portal', $campaign['original']['content'], $this->getPortalData());


    }

    public function grantAccess()
    {
        //http://www.ffwd.mx/

        $apGrantURL = session('base_grant_url');

        if (isset($apGrantURL)) {
            $query = parse_url($apGrantURL, PHP_URL_QUERY);

//            $bannerUrl = 'http://www.ffwd.mx/';
            $bannerUrl = url('ads');
            // Returns a string if the URL has parameters or NULL if not
            if ($query) {
                $apGrantURL .= '&continue_url=' . urlencode($bannerUrl);
            } else {
                $apGrantURL .= '?continue_url=' . urlencode($bannerUrl);
            }

            $apGrantURL .= '&redir=' . urlencode($bannerUrl);
            $apGrantURL .= '&duration=1800';

            session(['success_redirect_url'=>$bannerUrl]);


            $client_mac = session('client_mac');
            $log = CampaignLog::where('user.session', session('_token'))
                ->where('device.mac', $client_mac)->first();

            if ($log) {

                $log->interaction->accessed = new MongoDate();
                $log->interaction->save();

            }

            //dd($apGrantURL);

            return redirect($apGrantURL);
        } else {
            return redirect('portal');
        }

    }


    private function saveInputLog($input)
    {
        $inputLog = new InputLog;
        $inputLog->inputs = $input;
        $inputLog->save();
    }

    private function invalidNetworkView()
    {
        return view('welcome.invalid', [
            'main_bg' => 'bg_welcome.jpg'
        ]);
    }

    private function getPortalData()
    {
        //session input
        /**
         * 'base_grant_url' => $redirect_url,
         * 'user_continue_url' => $user_url,
         * 'node_mac' => $node_mac,
         * 'client_mac' => $client_mac
         */


        $branche = Branche::whereIn('aps', [session('node_mac')])->first();


        return [
            'network_name' => $branche->name,
            'image' => $branche->portal['image'],
            'message' => $branche->portal['message'],
            //'spinner_color' => $branche->portal['spinner_color'],
            //'login_response' => $this->fbUtils->makeLoginUrl($url),
            'grant_access_url' => url('grant_access'),
            'client_mac' => session('client_mac'),
        ];
    }
}
