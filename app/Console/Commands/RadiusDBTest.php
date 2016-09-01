<?php

namespace Portal\Console\Commands;

use DB;
use Illuminate\Console\Command;

class RadiusDBTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radius:select {user_mac}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if user exists in radius DB';

    protected $user_mac;

    /**
     * Create a new command instance.
     *
     * @return void
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
        $this->user_mac = $this->argument('user_mac');
//        $query="select * from radcheck where username='".$this->user_mac."';";

//        $this->info('Query: '.$query);

        $users = DB::connection('radius')->select("select * from radcheck where username=?", [$this->user_mac]);

        foreach ($users as $user)
        {
            $this->info('User retrieved: ' . $user["username"]);
        }
        /*

                $this->radius_secret = $this->argument('radius_secret');
                $this->user = $this->option('user');
                $this->pass = $this->option('pass');

                $radius = radius_auth_open();
                radius_add_server($radius, $this->radius_ip, 1812, $this->radius_secret, 5, 3);
                radius_create_request($radius, RADIUS_ACCESS_REQUEST);
                radius_put_attr($radius, RADIUS_USER_NAME, $this->user);
                radius_put_attr($radius, RADIUS_USER_PASSWORD, $this->pass);

                $result = radius_send_request($radius);

                switch ($result) {
                    case RADIUS_ACCESS_ACCEPT:
                        // An Access-Accept response to an Access-Request indicating that the RADIUS server authenticated the user successfully.
                        $this->info('Authentication successful');
                        break;
                    case RADIUS_ACCESS_REJECT:
                        // An Access-Reject response to an Access-Request indicating that the RADIUS server could not authenticate the user.
                        $this->error('Authentication failed');
                        break;
                    case RADIUS_ACCESS_CHALLENGE:
                        // An Access-Challenge response to an Access-Request indicating that the RADIUS server requires further information in another Access-Request before authenticating the user.
                        $this->error('Challenge required');
                        break;
                    default:
                        $this->error('A RADIUS error has occurred: ' . radius_strerror($radius));
                }*/
    }
}
