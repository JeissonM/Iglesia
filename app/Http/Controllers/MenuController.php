<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller {

    /**
     * Show the view menu usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function usuarios() {
        return view('menu.usuarios')->with('location', 'usuarios');
    }

    /**
     * Show the view menu feligresia.
     *
     * @return \Illuminate\Http\Response
     */
    public function feligresia() {
        return view('menu.feligresia')->with('location', 'feligresia');
    }

}
