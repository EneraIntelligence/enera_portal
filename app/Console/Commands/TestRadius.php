<?php

namespace Portal\Console\Commands;

use Illuminate\Console\Command;
use Portal\Libraries\Radius\Radius;

class TestRadius extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radius:auth {radius_ip} {radius_secret} {--U|user} {--P|password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auth to Radius Server';


    protected $radius_ip;
    protected $radius_secret;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->radius_ip = $this->argument('radius_ip');
        $this->radius_secret = $this->argument('radius_secret');
        $this->user = $this->option('user');
        $this->pass = $this->option('password');

        $radius = new Radius($this->radius_ip, $this->radius_secret);
        $radius->SetNasPort(0);
        $radius->SetNasIpAddress('127.0.1.1'); // Needed for some devices (not always auto-detected)

//        if ($radius->AccessRequest($this->user != "" ? $this->user : 'guest', $this->pass != "" ? $this->pass : 'guest')) {
        if ($radius->AccessRequest('enera','enera')) {
            $this->info('Authentication accepted');
        } else {
            $this->error('Authentication rejected');
        }
        $this->info($radius->GetReadableReceivedAttributes());
    }
}
