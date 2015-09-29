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
    var $id_campaign = '55c10856a8269769ac822f9a';

    public function __construct($id_camp)
    {
        $this->view = "/interaction/banner";
        $this->id_campaign = $id_camp;
    }

    /**
     *
     */
    public function getData()
    {

        $users = Campaign::where('_id', $this->id_campaign)->first();
        $contenido = $users->content;
//               $contenido = $users['content'];
        $this->data['imagen'] = $contenido['imagen'];
        $this->data['link'] = $contenido['link'];
//        var_dump($this->data);

        return $this->data;

    }




}