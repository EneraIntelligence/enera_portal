<?php

namespace Portal\Jobs;

use MongoDate;
use MongoId;
use Portal\CampaignLog;
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
        $log = CampaignLog::where('user.session', $this->token)
            ->where('device.mac', $this->client_mac)->first();

        // Paso 1: Welcome log
        if ($log && !isset($log->interaction->welcome)) {
            $log->interaction()->create(['welcome' => $this->welcome]);
        } elseif (!$log) {
            CampaignLog::create([
                'user' => [
                    'session' => $this->token
                ],
                'device' => [
                    'mac' => $this->client_mac
                ],
                'interaction' => [
                    '_id' => new MongoId(),
                    'welcome' => $this->welcome
                ]
            ]);
        }
    }
}
