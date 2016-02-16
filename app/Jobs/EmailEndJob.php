<?php

namespace Portal\Jobs;

use Mail;
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

    /**
     * Create a new job instance.
     *
     * @param $_id
     */
    public function __construct($_id)
    {
        $this->_id = $_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $user = Administrator::find($this->_id);
        Mail::send('mail.notifications', ['user' => $user], function ($m) use ($user) {
            $m->from('soporte@enera.mx', 'Enera Intelligence');
            $m->to($user->email, $user->name['first'] . ' ' . $user->name['last'])->subject('Finalización de Campaña por terminación de fondos');
        });
    }
}
