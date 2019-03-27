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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $grupos = Grupousuario::all()->sortBy('nombre')->pluck('nombre', 'id');
        return view('usuarios.usuarios.create')
                        ->with('location', 'usuarios')
                        ->with('grupos', $grupos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request) {
        $user = new User($request->all());
        foreach ($user->attributesToArray() as $key => $value) {
            if ($key === 'email') {
                $user->$key = $value;
            } elseif ($key === 'password') {
                $user->$key = bcrypt($value);
            } else {
                $user->$key = strtoupper($value);
            }
        }
        $u = Auth::user();
        $result = $user->save();
        $user->grupousuarios()->sync($request->grupos);
        if ($result) {
            $aud = new Auditoriausuario();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE USUARIO. DATOS: ";
            foreach ($user->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El usuario <strong>" . $user->nombres . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('admin.usuarios');
        } else {
            flash("El usuario <strong>" . $user->nombres . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('admin.usuarios');
        }
    }

    /**
     * Show the form for make operations width a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function operaciones() {
        $user = User::where('identificacion', $_POST["id"])->first();
        if ($user == null) {
            flash("<strong>El usuario</strong> consultado no se encuentra registrado!")->error();
            return redirect()->route('admin.usuarios');
        }
        $user->grupousuarios;
        $grupos = Grupousuario::all()->sortBy('nombre')->pluck('nombre', 'id');
        return view('usuarios.usuarios.edit')
                        ->with('location', 'usuarios')
                        ->with('grupos', $grupos)
                        ->with('user', $user);
    }

}
