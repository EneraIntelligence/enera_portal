<?php

namespace Portal\Jobs;

use DB;
use MongoDate;
use Portal\CampaignLog;
use Portal\CampaignLogInteraction;
use Portal\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class WelcomeLogJob extends Job implements SelfHandling
{
    protected $token;
    protected $client_mac;

    /**
     * Create a new job instance.
     * @param $data
     */
    public function __construct($data)
    {
        $this->token = $data['session'];
        $this->client_mac = $data['client_mac'];
        $this->welcome = new MongoDate();
    }

    /**
     * Execute the job.
     * Paso 1: Welcome Log
     *
     * @return void
     */
    public function handle()
    {
        // Paso 1: Welcome log
        DB::collection('campaign_logs')
            ->where('user.session', $this->token)
            ->where('device.mac', $this->client_mac)
            ->update([
                'user' => [
                    'session' => $this->token,
                ],
                'device' => [
                    'mac' => $this->client_mac
                ]
            ], array('upsert' => true));

        $log = CampaignLog::where('user.session', $this->token)
            ->where('device.mac', $this->client_mac)->first();

        if ($log && !isset($log->interaction->welcome)) {
            $log->created_at = new MongoDate();
            $log->save();
            $log->interaction()->create(['welcome' => $this->welcome]);
        }
    }
}
