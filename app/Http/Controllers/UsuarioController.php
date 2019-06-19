<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;
use App\User;
use App\Pagina;
use App\Modulo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Auditoriausuario;
use App\Asociacion;
use App\Iglesia;
use App\Grupousuario;

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = User::find($id);
        $m = new User($user->attributesToArray());
        foreach ($user->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key === 'email') {
                    $user->$key = $request->$key;
                } elseif ($key !== 'password') {
                    $user->$key = strtoupper($request->$key);
                }
            }
        }
        $u = Auth::user();
        $result = $user->save();
        $user->grupousuarios()->sync($request->grupos);
        if ($result) {
            $aud = new Auditoriausuario();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE USUARIO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($user->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El usuario <strong>" . $user->nombres . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('admin.usuarios');
        } else {
            flash("El usuario <strong>" . $user->nombres . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('admin.usuarios');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::find($id);
        $result = $user->delete();
        DB::table('grupousuario_user')->where('user_id', '=', $id)->delete();
        if ($result) {
            $aud = new Auditoriausuario();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE USUARIO. DATOS ELIMINADOS: ";
            foreach ($user->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El usuario <strong>" . $user->nombres . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('admin.usuarios');
        } else {
            flash("El usuario <strong>" . $user->nombres . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('admin.usuarios');
        }
    }

    //cambia la contraseña de cualquier usuario
    public function cambiarPass(Request $request) {
        if (strlen($request->pass1) < 6 or strlen($request->pass2) < 6) {
            flash('La nueva contraseña no puede tener menos de 6 caracteres.')->error();
            return redirect()->route('admin.usuarios');
        } else {
            if ($request->pass1 !== $request->pass2) {
                flash('Las contraseñas no coinciden.')->error();
                return redirect()->route('admin.usuarios');
            } else {
                $us = User::where('identificacion', $request->identificacion2)->first();
                $us->password = bcrypt($request->pass1);
                $u = Auth::user();
                if ($us->save()) {
                    $aud = new Auditoriausuario();
                    $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                    $aud->operacion = "ACTUALIZACIÓN DE DATOS";
                    $str = "CAMBIO DE CONTRASEÑA DE USUARIO. DATOS ELIMINADOS: ";
                    foreach ($us->attributesToArray() as $key => $value) {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                    $aud->detalles = $str;
                    $aud->save();
                    flash('Contraseña cambiada con exito.')->success();
                    return redirect()->route('admin.usuarios');
                } else {
                    flash('La contraseña no pudo ser cambiada.')->error();
                    return redirect()->route('admin.usuarios');
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function automatico() {
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        $roles = Grupousuario::all()->pluck('nombre', 'id');
        return view('usuarios.usuarios.automatico')
                        ->with('asociaciones', $asociaciones)
                        ->with('roles', $roles)
                        ->with('location', 'usuarios');
    }

    public function automaticostore(Request $request) {
        $i = Iglesia::find($request->iglesia_destino);
        if ($i != null) {
            $miembros = $i->feligres;
            if (count($miembros) > 0) {
                $usuarios = null;
                foreach ($miembros as $m) {
                    $u = null;
                    $u = User::where('identificacion', $m->personanatural->persona->numero_documento)->first();
                    if ($u == null) {
                        $u = new User();
                        $pn = $m->personanatural;
                        $u->identificacion = $pn->persona->numero_documento;
                        $u->nombres = $pn->primer_nombre . " " . $pn->segundo_nombre;
                        $u->apellidos = $pn->primer_apellido . " " . $pn->segundo_apellido;
                        $u->email = $pn->persona->mail;
                        $u->estado = "ACTIVO";
                        $u->password = Hash::make('00000000');
                        $usuarios[] = $u;
                    }
                }
                if ($usuarios != null) {
                    $hoy = getdate();
                    $response[] = "**********************************************************************************";
                    $response[] = " GENERACIÓN MASIVA DE USUARIOS PARA LA IGLESIA " . $i->nombre . ". FECHA: " . $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"];
                    $response[] = "**********************************************************************************";
                    $response[] = "                                                                        ";
                    $response[] = "                                                                        ";
                    foreach ($usuarios as $us) {
                        if ($us->save()) {
                            $us->grupousuarios()->sync($request->rol);
                            $response[] = "     IDENTIFICACIÓN: " . $us->identificacion;
                            $response[] = "     USUARIO: " . $us->nombres . " " . $us->apellidos;
                            $response[] = "[OK] USUARIO CREADO CON ÉXITO";
                            $response[] = "__________________________________________________________________________________";
                        } else {
                            $response[] = "     IDENTIFICACIÓN: " . $us->identificacion;
                            $response[] = "     USUARIO: " . $us->nombres . " " . $us->apellidos;
                            $response[] = "[xx] EL USUARIO NO PUDO SER CREADO.";
                            $response[] = "__________________________________________________________________________________";
                        }
                    }
                    $archivo = "LOG_GENERACION_USUARIOS_IGELSIA_" . $i->nombre . "_" . "_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . ".txt";
                    $file = fopen(public_path() . "/docs/usuarios/" . $archivo, 'w+');
                    foreach ($response as $value) {
                        fwrite($file, $value . PHP_EOL);
                    }
                    fclose($file);
                    $r['archivo'] = $archivo;
                    $r['resultado'] = $response;
                    return view('usuarios.usuarios.automaticoresultado')
                                    ->with('location', 'usuarios')
                                    ->with('response', $r);
                } else {
                    flash("No hay miembros en la igelsia " . $i->nombre . " sin usuario.")->error();
                    return redirect()->route('usuario.automatico');
                }
            } else {
                flash("No hay miembros en la igelsia " . $i->nombre)->error();
                return redirect()->route('usuario.automatico');
            }
        } else {
            flash("No se pudo establecer la iglesia seleccionada para realizar el proceso!")->error();
            return redirect()->route('usuario.automatico');
        }
    }

}
