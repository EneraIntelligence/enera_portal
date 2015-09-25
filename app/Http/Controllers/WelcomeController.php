<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;

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

    /**
     * Muestra la pantalla de red invalida
     *
     */
    public function invalid()
    {
        //
    }
}
