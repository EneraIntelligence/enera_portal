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
     * @param $campaign
     */
    public function __construct($campaign)
    {

        $this->view = "/interaction/banner";
        $this->campaign = $campaign;
        //var_dump($this->campaign);
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
        $this->data['link'] = $this->campaign['content']['link'];
        $this->data['imagen'] = $this->campaign['content']['imagen'];
        $this->data['idcamp'] = $this->campaign['_id'];;

//        var_dump($this->data);
//               $contenido = $users['content'];
        return $this->data;

    }




}