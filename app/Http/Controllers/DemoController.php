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

    public function login()
    {
        return view("welcome.login");
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

        $campaignType = "Portal\\Libraries\\Interactions\\Captcha";
        $interaction = new $campaignType($campaignSelected);
        $campaignSelected->content = array(
            'images' => [
                'small' => "1461297338.jpg",
                "large" => "1461297353.jpg"
            ],
            $interaction->getData(),
            'captcha' => 'test'
        );

//        $campaignType = "Portal\\Libraries\\Interactions\\Captcha";
        $interaction = new $campaignType($campaignSelected);

        $link['link'] = "http://enera.mx";
        return view($interaction->getView(), $link, array_merge(
            ['_id' => $campaignSelected->_id],
            $interaction->getData(),
            ['fb_id' => '10206656662069174']
        ));
    }

    public function brandcaptcha()
    {
        //hardcoded brandcaptcha
        $campaignSelected = new Campaign();
        $campaignSelected->_id = "demo_brandcaptcha";

        $campaignType = "Portal\\Libraries\\Interactions\\BrandCaptcha";
        $interaction = new $campaignType($campaignSelected);

        $link['link'] = "http://enera.mx";
        return view($interaction->getView(), $link, array_merge(
            ['_id' => $campaignSelected->_id],
            ['fb_id' => '10206656662069174'],
            ['public_key'=>'437969bb4001422bd3df303e7c819e9746a6aea6']
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
        //hardcoded video
        $campaignSelected = new Campaign();
        $campaignSelected->_id = "demo_video";
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
