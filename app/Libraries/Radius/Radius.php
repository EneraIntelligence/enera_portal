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
        $this->radius = radius_auth_open();

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

        if ($this->response == RADIUS_ACCESS_ACCEPT) {

            radius_create_request($this->radius, RADIUS_ACCESS_REQUEST);
            radius_put_attr($this->radius, RADIUS_USER_NAME, $user);
            radius_put_attr($this->radius, RADIUS_USER_PASSWORD, $pass);


            radius_put_string($this->radius, RADIUS_NAS_IDENTIFIER, '6C-AA-B3-2D-A8-98');
            radius_put_addr($this->radius, RADIUS_NAS_IP_ADDRESS, '192.168.128.14');
            radius_put_addr($this->radius, RADIUS_FRAMED_IP_ADDRESS , "192.168.128.3");
            radius_put_string($this->radius,RADIUS_CALLED_STATION_ID, "6C-AA-B3-2D-A8-98:WIFI_RUCKUS");
            radius_put_int($this->radius, RADIUS_SERVICE_TYPE, RADIUS_LOGIN);
            radius_put_string($this->radius,RADIUS_CALLING_STATION_ID, "DC-9B-9C-4A-B6-C1");
            radius_put_int($this->radius,RADIUS_NAS_PORT_TYPE , RADIUS_WIRELESS_IEEE_802_11);


            radius_put_int($this->radius, RADIUS_NAS_PORT, 3);
            radius_put_string($this->radius,RADIUS_NAS_IDENTIFIER , "6C-AA-B3-2D-A8-98");
            radius_put_int($this->radius,RADIUS_ACCT_STATUS_TYPE, RADIUS_START);
            radius_put_int($this->radius,RADIUS_ACCT_AUTHENTIC, RADIUS_AUTH_RADIUS);


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