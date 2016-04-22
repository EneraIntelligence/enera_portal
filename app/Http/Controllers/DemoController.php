<?php

namespace Portal\Http\Controllers;

use Portal\Http\Requests;
use Portal\Campaign;


class DemoController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Pantalla con demos de cada interacción
     *
     */
    public function index()
    {
        return view("welcome.demo");
    }

    public function like()
    {
        //hardcoded like
        $campaignSelected = new Campaign();
        $campaignSelected->_id = "demo_like";
        $campaignSelected->content = array(
            'images' => array(
                'small' => "1461297338.jpg",
                "large" => "1461297353.jpg"
            ),
            'like_url' => 'https://www.facebook.com/eneraintelligence/'
        );

        $campaignType = "Portal\\Libraries\\Interactions\\Like";
        $interaction = new $campaignType($campaignSelected);

        $link['link'] = "http://enera.mx";

        //http://graph.facebook.com/{{fbid}}/picture?type=square

        return view($interaction->getView(), $link, array_merge(
            ['_id' => $campaignSelected->_id],
            $interaction->getData(),
            ['fb_id' => '10206656662069174']
        ));
    }

    public function banner_link()
    {
        //hardcoded banner link
        $campaignSelected = new Campaign();
        $campaignSelected->_id = "demo_banner";
        $campaignSelected->content = array(
            'images' => array(
                'small' => "1461297338.jpg",
                "large" => "1461297353.jpg"
            ),
            'banner_link' => 'http://enera.mx'
        );

        $campaignType = "Portal\\Libraries\\Interactions\\BannerLink";
        $interaction = new $campaignType($campaignSelected);

        $link['link'] = "http://enera.mx";
        return view($interaction->getView(), $link, array_merge(
            ['_id' => $campaignSelected->_id],
            $interaction->getData(),
            ['fb_id' => '10206656662069174']
        ));
    }

    public function mailing_list()
    {
        //hardcoded mailing list
        $campaignSelected = new Campaign();
        $campaignSelected->_id = "demo_mailing";
        $campaignSelected->content = array(
            'images' => array(
                "small" => "1456271559.jpg",
                "large" => "1456271572.jpg",
            )
        );

        $campaignType = "Portal\\Libraries\\Interactions\\MailingList";
        $interaction = new $campaignType($campaignSelected);

        $link['link'] = "http://enera.mx";
        return view($interaction->getView(), $link, array_merge(
            ['_id' => $campaignSelected->_id],
            $interaction->getData(),
            ['fb_id' => '10206656662069174']
        ));
    }

    public function captcha()
    {
        //hardcoded captcha
        $campaignSelected = new Campaign();
        $campaignSelected->_id = "demo_captcha";
        $campaignSelected->content = array(
            'images' => array(
                'small' => "1461297338.jpg",
                "large" => "1461297353.jpg"
            )
        );

        $campaignType = "Portal\\Libraries\\Interactions\\Captcha";
        $interaction = new $campaignType($campaignSelected);

        $link['link'] = "http://enera.mx";
        return view($interaction->getView(), $link, array_merge(
            ['_id' => $campaignSelected->_id],
            $interaction->getData(),
            ['fb_id' => '10206656662069174']
        ));
    }

    public function encuesta()
    {
        //hardcoded captcha
        $campaignSelected = new Campaign();
        $campaignSelected->_id = "demo_encuesta";
        $campaignSelected->content = array(
            'images' => array(
                "survey" => "1461298197.jpg"
            ),
            "survey" => array(
                "q1" => array(
                    "question" => "¿Tienes coche propio?",
                    "answers" => array(
                        "a0" => "Si",
                        "a1" => "No"
                    )
                ),
                "q2" => array(
                    "question" => "¿Cada cuando sales de viaje de negocios?",
                    "answers" => array(
                        "a0" => "3-5 veces por mes",
                        "a1" => "1-2 veces por mes",
                        "a2" => "cada dos meses",
                        "a3" => "No salgo de viaje"
                    )
                ),
                "q3" => array(
                    "question" => "¿Cada cuando sales viaje por placer?",
                    "answers" => array(
                        "a0" => "4-7 veces al año",
                        "a1" => "2-3 veces al año",
                        "a2" => "1 vez año",
                        "a3" => "No salgo de viaje"
                    )
                ),
                "q4" => array(
                    "question" => "Cuando sales de viaje por placer ¿Con quién viajas? ",
                    "answers" => array(
                        "a0" => "Familia",
                        "a1" => "Amigos",
                        "a2" => "Pareja",
                        "a3" => "Solo"
                    )
                ),
                "q5" => array(
                    "question" => "¿Que paginas para reservar hoteles utilizas? ",
                    "answers" => array(
                        "a0" => "hoteles.com",
                        "a1" => "trivago.com",
                        "a2" => "expedia.com",
                        "a3" => "otro"
                    )
                )
            )
        );

        $campaignType = "Portal\\Libraries\\Interactions\\Survey";
        $interaction = new $campaignType($campaignSelected);

        $link['link'] = "http://enera.mx";
        return view($interaction->getView(), $link, array_merge(
            ['_id' => $campaignSelected->_id],
            $interaction->getData(),
            ['fb_id' => '10206656662069174']
        ));
    }

    public function video()
    {
        //hardcoded captcha
        $campaignSelected = new Campaign();
        $campaignSelected->_id = "demo_encuesta";
        $campaignSelected->content = array(
            'images' => array(
                "small" => "1452901991.jpg",
                "large" => "1452901997.jpg",
            ),
            "video" => "trailer.mp4"
        );

        $campaignType = "Portal\\Libraries\\Interactions\\Video";
        $interaction = new $campaignType($campaignSelected);

        $link['link'] = "http://enera.mx";
        return view($interaction->getView(), $link, array_merge(
            ['_id' => $campaignSelected->_id],
            $interaction->getData(),
            ['fb_id' => '10206656662069174']
        ));
    }
}
