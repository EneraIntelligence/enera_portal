<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use MongoDate;
use Portal\Branche;
use Portal\CampaignLog;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\InputLog;
use Portal\Libraries\APAdapters\APUtils;

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

        if(env('APP_ENV')=='local')
        {
            //simulating input for testing
            $rawInput['node_mac'] = "ac:86:74:50:48:e0";//concentro branch
            $rawInput['base_grant_url'] = 'http:ederdiaz.com';
            $rawInput['user_continue_url'] = 'http:ederdiaz.com';
            $rawInput['client_mac'] = 'aa:bb:aa:bb:aa:bb';
        }

        //detecta marca de ap y asigna un adaptador
        $inputAdapter = APUtils::getAPAdapter($rawInput);

        if ($inputAdapter == null)
        {
            $this->saveInputLog($rawInput);
            return $this->invalidNetworkView();
        }

        //ajusta los inputs al estandar de enera
        $input = $inputAdapter->processInput($rawInput);

        session($input);
        session(['campaign_id'=>'580e7414fd30b44734ebd6c7']);

        return view('welcome.portal', $this->getPortalData());


    }

    public function grantAccess()
    {
        //http://www.ffwd.mx/

        $apGrantURL =session('base_grant_url');

        if( isset( $apGrantURL ) )
        {
            $query = parse_url($apGrantURL, PHP_URL_QUERY);

            $bannerUrl = 'http://www.ffwd.mx/';
            // Returns a string if the URL has parameters or NULL if not
            if ($query) {
                $apGrantURL .= '&continue_url='.urlencode($bannerUrl) ;
            } else {
                $apGrantURL .= '?continue_url='.urlencode($bannerUrl) ;
            }

            $apGrantURL .= '&redir='.urlencode($bannerUrl) ;
            $apGrantURL .= '&duration=1800';

            session(['success_redirect_url'=>$bannerUrl]);


            $client_mac = session('client_mac');
            $log = CampaignLog::where('user.session', session('_token'))
                ->where('device.mac', $client_mac)->first();

            if ($log)
            {

                $log->interaction->accessed = new MongoDate();
                $log->interaction->save();

            }

            //dd($apGrantURL);
            
            return redirect($apGrantURL);
        }
        else
        {
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
            'grant_access_url'=>url('grant_access'),
            'client_mac' => session('client_mac'),
        ];
    }
}
