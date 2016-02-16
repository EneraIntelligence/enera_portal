<?php

namespace Portal\Jobs;

use DB;
use Portal\User;
use Portal\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class FbLikesJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $likes;
    protected $fb_id;
    protected $mac;

    /**
     * Create a new job instance.
     * @param $likes
     * @param $fb_id
     * @param $user_mac
     */
    public function __construct($likes, $fb_id, $user_mac)
    {
        $this->likes = $likes;
        $this->fb_id = $fb_id;
        $this->mac = $user_mac;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where('facebook.id', $this->fb_id)->first();
        if ($user) {
            $user_device = $user->devices()->where('mac', $this->mac)->first();
            if ($user_device) {
                $user_device->mac = $this->mac;
                $user_device->save();
            } else {
                $user->devices()->create([
                    'mac' => $this->mac,
                    'os' => '',
                    'manufacturer' => ''
                ]);
            }

            if ($user->facebook->likes->count() == 0) {
                $user->facebook->likes = [];
                $user->facebook->save();
            }

            foreach ($this->likes as $like) {
                DB::collection('facebook_pages')->where('id', $like['id'])
                    ->update($like, ['upsert' => true]);
                $user->facebook()->push('facebook.likes', $like['id'], true);
            }
        }
    }
}
