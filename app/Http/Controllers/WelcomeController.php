<?php

namespace EneraPortal\Http\Controllers;

use Illuminate\Http\Request;

use EneraPortal\Http\Requests;
use EneraPortal\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * Muestra la pantalla de bievenida a la red
     *
     * @return Response
     */
    public function index()
    {
        return "HOLA MUNDO!!";
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
