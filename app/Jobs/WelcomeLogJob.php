<?php

namespace Portal\Jobs;

use Bugsnag;
use MongoId;
use MongoDate;
use Portal\Branche;
use Portal\Jobs\Job;
use Portal\CampaignLog;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeLogJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $token;
    protected $client_mac;
    protected $welcome;
    protected $node_mac;
    protected $os;

    /**
     * Create a new job instance.
     * @param $data
     */
    public function __construct($data)
    {
        $this->token = $data['session'];
        $this->client_mac = $data['client_mac'];
        $this->welcome = new MongoDate();
        $this->node_mac = $data['node_mac'];
        $this->os = $data['os'];
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
            $new_log = CampaignLog::create([
                'user' => [
                    'session' => $this->token
                ],
                'device' => [
                    'mac' => $this->client_mac,
                    'node_mac' => $this->node_mac,
                    'os' => $this->os,
                    'branch_id' => Branche::whereIn('aps', [$this->node_mac])->first()->_id,
                ]
            ]);
            $new_log->interaction()->create([
                'welcome' => $this->welcome
            ]);
            if (!$new_log) {
                Bugsnag::notifyError("CreateDocument", "El documento CampaignLog no se pudo crear client_mac: " . $this->client_mac);
            }
        }
    }
}
