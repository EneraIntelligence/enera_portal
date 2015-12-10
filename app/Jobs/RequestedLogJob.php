<?php

namespace Portal\Jobs;

use DateTime;
use MongoDate;
use Portal\CampaignLog;
use Portal\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Portal\User;

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
        $this->user_id = $data['user_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Paso 3: Registered log
        $log = CampaignLog::where('user.session', $this->token)
            ->where('device.mac', $this->client_mac)->first();

        if ($log) {
            $log->campaign_id = $this->campaign_id;
            $user = isset($log->user['id']) ? $this->user : User::find($this->user_id);
            $u['id'] = $user->_id;
            $u['gender'] = $user->facebook->gender;
            /**/
            $birthday = new DateTime($user->facebook->birthday['date']);
            $today = date('Y-m-d');
            $age = $birthday->diff(new DateTime($today));
            /**/
            $u['age'] = $age->y;
            $u['session'] = session('_token');
            $log->user = $u;
            $log->save();

            if (!isset($log->interaction->requested)) {
                $log->interaction->requested = $this->requested;
                $log->interaction->save();
            }
        }
    }
}
