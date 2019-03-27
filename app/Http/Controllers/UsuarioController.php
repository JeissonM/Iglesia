<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;
use App\User;
use App\Grupousuario;
use App\Pagina;
use App\Modulo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Auditoriausuario;

class UsuarioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $usuarios = User::all();
        $usuarios->each(function ($usuario) {
            $usuario->grupousuarios;
        });
        return view('usuarios.usuarios.list')
                        ->with('location', 'usuarios')
                        ->with('usuarios', $usuarios);
    }

}
