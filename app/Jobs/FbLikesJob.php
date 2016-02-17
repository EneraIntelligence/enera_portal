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
    protected $os;

    /**
     * Create a new job instance.
     * @param $likes
     * @param $fb_id
     * @param $user_mac
     * @param $os
     */
    public function __construct($likes, $fb_id, $user_mac, $os)
    {
        $this->likes = $likes;
        $this->fb_id = $fb_id;
        $this->mac = $user_mac;
        $this->os = $os;
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
            $user_device = $user->devices()->where('devices.mac', $this->mac)->first();
            if ($user_device) {
                $user_device->mac = $this->mac;
                $user_device->save();
            } else {
                $user->devices()->create([
                    'mac' => $this->mac,
                    'os' => $this->os,
                    'manufacturer' => ''
                ]);
            }

            if (count($user->facebook->likes) == 0) {
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
