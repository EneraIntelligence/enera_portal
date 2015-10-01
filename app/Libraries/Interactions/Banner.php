<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:25 AM
 */

namespace Portal\Libraries\Interactions;


use Portal\Libraries\Enera;
use Portal\Campaign;

class Banner extends Enera
{
    protected $data;
//    var $id_campaign = '55c10856a8269769ac822f9a';
    var $campaign;

    /**
     * Banner constructor.
     * @param $campaña
     */
    public function __construct($campaña)
    {
        $this->view = "/interaction/banner";
        $this->campaign = $campaña;
        var_dump($this->campaign);
    }

    /**
     *
     */
    public function getData()
    {

        /*$users = Campaign::where('_id', $this->id_campaign)->first();
        $contenido = $users->content;

        $this->data['imagen'] = $contenido['imagen'];
        $this->data['link'] = $contenido['link'];*/
        $this->data['link'] = 'www.enera.mx';
        $this->data['imagen'] = 'enera_logo.png';
        $this->data['idcamp'] = '12345';

//        var_dump($this->data);
//               $contenido = $users['content'];
        return $this->data;

    }




}