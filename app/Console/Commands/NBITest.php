<?php

namespace Portal\Console\Commands;

use Illuminate\Console\Command;

class NBITest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enera:NBITest';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //

//        $url = "https://207.248.45.101:9443/portalintf";
        $url = "http://207.248.45.101:9080/portalintf";

        $json_data = array(
            "Vendor" => "ruckus",
            "RequestPassword" => "t3!um123",
            "APIVersion" => "1.0",
            "RequestCategory" => "GetConfig",
            "RequestType" => "Encrypt",
            "Data" => "04:4f:aa:32:25:f0"
        );

        $json_response = $this->makeCurl($url, $json_data);

        $response = json_decode($json_response, true);

        $this->info("Enc-mac: " . $response['Data']);
        $encMac = $response['Data'];
        //end mac




        //start ip
        $json_data = array(
            "Vendor" => "ruckus",
            "RequestPassword" => "t3!um123",
            "APIVersion" => "1.0",
            "RequestCategory" => "GetConfig",
            "RequestType" => "Encrypt",
            "Data" => "172.21.134.101"
        );
        $json_response = $this->makeCurl($url, $json_data);
        $response = json_decode($json_response, true);

        $this->info("Enc-ip: " . $response['Data']);
        $encIp = $response['Data'];

        //end ip



        //start login


        $json_data = array(
            "Vendor" => "ruckus",
            "RequestPassword" => "t3!um123",
            "APIVersion" => "1.0",
            "RequestCategory" => "UserOnlineControl",
            "RequestType" => "Login",
            "UE-IP" => $encIp,
            "UE-MAC" => $encMac,
            "UE-Proxy" => "0",
            "UE-Username" => "enera",
            "UE-Password" => "enera"
        );

        $json_response = $this->makeCurl($url, $json_data);

        $this->info("response: " . $json_response);


    }


    private function makeCurl($url, $json_data)
    {
        $content = json_encode($json_data);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($status != 200)
        {
            //error
            die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }


        curl_close($curl);

        return $json_response;
    }

}
