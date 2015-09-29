<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use MongoDate;
use Portal\Campaign;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * Muestra la pantalla de bievenida a la red
     *
     * @return Response
     */
    public function index()
    {
        return view('welcome.index');
    }

    public function captcha()
    {
        $campaign = Campaign::find('55f6ee95a8265d9826c506cc');
        $c = new Campaign();
        return view('welcome.captcha', ['captcha' => $campaign->content['captcha'], 'cover' => $campaign->content['cover_path'], 'c' => $c]);
    }

    /**
     * Muestra la pantalla de red invalida
     *
     */
    public function invalid()
    {
        //
    }
}
