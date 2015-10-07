<?php

namespace Portal\Jobs;

use DB;
use Portal\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Portal\User;

class FbLikesJob extends Job implements SelfHandling
{
    protected $likes;
    protected $fb_id;

    /**
     * Create a new job instance.
     * @param $likes
     * @param $fb_id
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
        $likes = [];
        foreach ($this->likes as $like) {
            DB::collection('facebook_pages')->where('id', $like['id'])
                ->update($like, array('upsert' => true));
            $likes[] = $like['id'];
        }

        //upsert user data
        $user = User::where('facebook.id', $this->fb_id)->first();

        $user->facebook->likes = $likes;
        $user->facebook->save();
    }
}
