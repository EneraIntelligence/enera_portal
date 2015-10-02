<?php

namespace Portal\Jobs;

use DB;
use Portal\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class FbLikesJob extends Job implements SelfHandling
{
    protected $likes;
    protected $fb_id;

    /**
     * Create a new job instance.
     *
     */
    public function __construct($likes, $fb_id)
    {
        $this->likes = $likes;
        $this->fb_id = $fb_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->likes as $like) {
            DB::collection('facebookpages')->where('id', $like['id'])
                ->update($like, array('upsert' => true));

            $userData['facebook']['likes'][] = $like['id'];
        }
        //upsert user data
        DB::collection('users')->where('facebook.id', $this->fb_id)
            ->update($userData, array('upsert' => true));

    }
}
