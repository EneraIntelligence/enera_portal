<?php

namespace Portal\Jobs;

use Mail;
use Portal\User;
use Portal\Campaign;
use Portal\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class SendFirstMailJob extends Job implements SelfHandling
{
    protected $campaign;
    protected $user;

    /**
     * Create a new job instance.
     * @param $campaign
     * @param $user
     */
    public function __construct(Campaign $campaign, User $user)
    {
        $this->campaign = $campaign;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('mail.generic', [], function ($mail) use ($user) {
            $m->from($mail["from_mail"], $mail["from"]);

            //TODO tomar mails de campaña y mandar a todos
            $m->to("ederchrono@gmail.com", "Eder")->subject($mail["subject"]);
        });
    }
}
