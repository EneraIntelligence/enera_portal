<?php

namespace Portal\Jobs;

use Mail;
use Portal\Campaign;
use Portal\Jobs\Job;
use Portal\Administrator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailEndJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $_id;
    protected $cam;

    /**
     * Create a new job instance.
     *
     * @param $_id
     * @param $cam
     */
    public function __construct($_id, $cam)
    {
        $this->_id = $_id;
        $this->cam = $cam;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $user = Administrator::find($this->_id);
        $campaign = Campaign::find($this->cam);
        Mail::send('mail.notifications', ['user' => $user, 'cam' => $campaign], function ($m) use ($user) {
            $m->from('soporte@enera.mx', 'Enera Intelligence');
            $m->to('darkdreke@gmail.com', $user->name['first'] . ' ' . $user->name['last'])->subject('Finalización de Campaña por terminación de fondos');
        });
    }
}
