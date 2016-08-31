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
        
        //test if this gives access
        radius_put_addr($this->radius, RADIUS_NAS_IP_ADDRESS, '192.168.128.14');

        radius_create_request($this->radius, RADIUS_ACCESS_REQUEST);
        radius_put_attr($this->radius, RADIUS_USER_NAME, $user);
        radius_put_attr($this->radius, RADIUS_USER_PASSWORD, $pass);

        $this->response = radius_send_request($this->radius);

        if ($this->response == RADIUS_ACCESS_ACCEPT) {
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