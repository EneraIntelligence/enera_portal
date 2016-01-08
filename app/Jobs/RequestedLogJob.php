<?php

namespace Portal\Jobs;

use DateTime;
use MongoDate;
use Portal\User;
use Portal\Jobs\Job;
use Portal\CampaignLog;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestedLogJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $campaign_id;
    protected $token;
    protected $client_mac;
    protected $requested;
    protected $user_id;
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
            $user = /*isset($log->user['id']) ? $log->user : */
                User::find($this->user_id);
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
