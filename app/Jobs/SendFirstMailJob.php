<?php

namespace Portal\Jobs;

use Mail;
use Portal\User;
use Portal\Campaign;
use Portal\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFirstMailJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $campaign;
    protected $user;

    /**
     * Create a new job instance.
     * @param Campaign $campaign
     * @param User $user
     */
    public function __construct(Campaign $campaign, User $user)
    {
        $this->campaign = $campaign;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $user = $this->user;
        $camp = $this->campaign;
        Mail::send('mail.generic', ['content' => $camp->content['mail']['content']], function ($mail) use ($user, $camp) {
            $mail->from($camp->content['mail']['from_mail'], $camp->content['mail']['from_name']);
            $mail->to($user->facebook->email, $user->facebook->first_name)->subject($camp->content['mail']['subject']);
        });
    }
}
