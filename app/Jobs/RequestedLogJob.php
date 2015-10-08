<?php

namespace Portal\Jobs;

use MongoDate;
use Portal\CampaignLog;
use Portal\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class RequestedLogJob extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     * @param $data
     */
    public function __construct($data)
    {
        $this->campaign_id = $data['campaign_id'];
        $this->token = $data['session'];
        $this->client_mac = $data['client_mac'];
        $this->requested = new MongoDate();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Paso 3: Registered log
        /*DB::collection('campaign_logs')
            ->where('user.session', $this->token)
            ->where('device.mac', $this->client_mac)
            ->update([
                'user' => [
                    'session' => $this->token,
                ],
                'device' => [
                    'mac' => $this->client_mac
                ]
            ], array('upsert' => true));*/

        $log = CampaignLog::where('user.session', $this->token)
            ->where('device.mac', $this->client_mac)->first();

        if ($log && isset($log->interaction->requested)) {
            $log->campaign_id = $this->campaign_id;
            $log->save();
            $log->interaction->requested = $this->requested;
            $log->interaction->save();
        }
    }
}
