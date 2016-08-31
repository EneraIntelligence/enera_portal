<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 8/30/16
 * Time: 12:28 PM
 */

namespace Portal\Libraries\Radius;


class Radius
{
    protected $radius;
    protected $radius_ip;
    protected $radius_secret;
    protected $radius_port;
    protected $response;

    public function __construct()
    {
        $this->radius_ip = env('RADIUS_IP');
        $this->radius_secret = env('RADIUS_SECRET');
        $this->radius_port = env('RADIUS_PORT', 1812);
        $this->radius_acct_port = env('RADIUS_ACCCT_PORT', 1813);
        $this->radius = radius_auth_open();
        $this->radiusAcct = radius_acct_open();

    }

    /**
     * @param $user
     * @param $pass
     * @return bool
     */
    public function auth($user, $pass)
    {
        radius_add_server($this->radius, $this->radius_ip, $this->radius_port, $this->radius_secret, 5, 3);

        radius_create_request($this->radius, RADIUS_ACCESS_REQUEST);
        radius_put_attr($this->radius, RADIUS_USER_NAME, $user);
        radius_put_attr($this->radius, RADIUS_USER_PASSWORD, $pass);


        /**
         *
        rad_recv: Access-Request packet from host 189.168.139.141 port 17315, id=18, length=181
        User-Name = "enera"
        User-Password = "enera"
        NAS-Identifier = "6C-AA-B3-6D-A8-98"
        NAS-IP-Address = 192.168.128.14
        Framed-IP-Address = 192.168.128.3
        Called-Station-Id = "6C-AA-B3-6D-A8-98:RUCKUS_CAPTIVE"
        Service-Type = Login-User
        Calling-Station-Id = "DC-9B-9C-4A-B6-C1"
        NAS-Port-Type = Wireless-802.11
        Ruckus-Attr-3 = 0x5255434b55535f43415054495645
        Message-Authenticator = 0x378014f18df9e4b5976ebfc5e954946e
         */
        //test if this gives access

        radius_put_string($this->radius, RADIUS_NAS_IDENTIFIER, '6C-AA-B3-2D-A8-98');
        radius_put_addr($this->radius, RADIUS_NAS_IP_ADDRESS, '192.168.128.14');
        radius_put_addr($this->radius, RADIUS_FRAMED_IP_ADDRESS , "192.168.128.3");
        radius_put_string($this->radius,RADIUS_CALLED_STATION_ID, "6C-AA-B3-2D-A8-98:WIFI_RUCKUS");
        radius_put_int($this->radius, RADIUS_SERVICE_TYPE, RADIUS_LOGIN);
        radius_put_string($this->radius,RADIUS_CALLING_STATION_ID, "DC-9B-9C-4A-B6-C1");
        radius_put_int($this->radius,RADIUS_NAS_PORT_TYPE , RADIUS_WIRELESS_IEEE_802_11);

        /*
        radius_put_int($this->radius, RADIUS_NAS_PORT, 3);

        radius_put_string($this->radius,RADIUS_NAS_IDENTIFIER , "6C-AA-B3-2D-A8-98");

        radius_put_int($this->radius,RADIUS_ACCT_STATUS_TYPE, RADIUS_START);
        radius_put_int($this->radius,RADIUS_ACCT_AUTHENTIC, RADIUS_AUTH_RADIUS);
*/

        $this->response = radius_send_request($this->radius);

        /**
         * rad_recv: Accounting-Request packet from host 189.168.139.141 port 17318, id=1, length=239
        User-Name = "enera"
        Acct-Status-Type = Start
        Acct-Authentic = RADIUS
        Framed-IP-Address = 192.168.128.3
        Calling-Station-Id = "DC-9B-9C-4A-B6-C1"
        NAS-IP-Address = 192.168.128.14
        NAS-Port = 7
        Called-Station-Id = "6C-AA-B3-6D-A8-9C:RUCKUS_CAPTIVE"
        NAS-Port-Type = Wireless-802.11
        NAS-Identifier = "6C-AA-B3-6D-A8-9C"
        Connect-Info = "CONNECT 802.11a/n"
        Acct-Session-Id = "57E5A277-0000000A"
        Acct-Multi-Session-Id = "6caab36da898dc9b9c4ab6c157c7292e0057"
        Ruckus-Attr-3 = 0x5255434b55535f43415054495645
        Event-Timestamp = "Aug 31 2016 15:00:34 EDT"
         */

        echo $this->response.'<br>';

        if ($this->response == RADIUS_ACCESS_ACCEPT) {

            radius_add_server($this->radiusAcct, $this->radius_ip, $this->radius_acct_port, $this->radius_secret, 5, 3);


            radius_create_request($this->radiusAcct, RADIUS_ACCOUNTING_REQUEST);
            radius_put_attr($this->radiusAcct, RADIUS_USER_NAME, $user);

            radius_put_string($this->radiusAcct, RADIUS_NAS_IDENTIFIER, '6C-AA-B3-6D-A8-9C');
            radius_put_addr($this->radiusAcct, RADIUS_NAS_IP_ADDRESS, '192.168.128.14');
            radius_put_addr($this->radiusAcct, RADIUS_FRAMED_IP_ADDRESS , "192.168.128.3");
            radius_put_string($this->radiusAcct,RADIUS_CALLED_STATION_ID, "6C-AA-B3-6D-A8-9C:RUCKUS_CAPTIVE");
            radius_put_int($this->radiusAcct, RADIUS_SERVICE_TYPE, RADIUS_LOGIN);
            radius_put_string($this->radiusAcct,RADIUS_CALLING_STATION_ID, "DC-9B-9C-4A-B6-C1");
            radius_put_int($this->radiusAcct,RADIUS_NAS_PORT_TYPE , RADIUS_WIRELESS_IEEE_802_11);


            radius_put_int($this->radiusAcct, RADIUS_NAS_PORT, 7);
            radius_put_string($this->radiusAcct,RADIUS_NAS_IDENTIFIER , "6C-AA-B3-2D-A8-98");
            radius_put_int($this->radiusAcct,RADIUS_ACCT_STATUS_TYPE, RADIUS_START);
            radius_put_int($this->radiusAcct,RADIUS_ACCT_AUTHENTIC, RADIUS_AUTH_RADIUS);

            $this->response = radius_send_request($this->radiusAcct);
            echo $this->response.'<br>';


                return true;
            } else {
                return false;
            }
        }

        /**
         * @return radius_response
         */
    public function Response()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function strResponse()
    {
        switch ($this->response) {
            case RADIUS_ACCESS_ACCEPT:
                // An Access-Accept response to an Access-Request indicating that the RADIUS server authenticated the user successfully.
                return 'Authentication successful';
                break;
            case RADIUS_ACCESS_REJECT:
                // An Access-Reject response to an Access-Request indicating that the RADIUS server could not authenticate the user.
                return 'Authentication failed';
                break;
            case RADIUS_ACCESS_CHALLENGE:
                // An Access-Challenge response to an Access-Request indicating that the RADIUS server requires further information in another Access-Request before authenticating the user.
                return 'Challenge required';
                break;
            default:
                return 'A RADIUS error has occurred: ' . radius_strerror($this->radius);
        }
    }
}