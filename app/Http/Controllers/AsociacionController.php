<?php

namespace App\Http\Controllers;

use App\Asociacion;
use App\Ciudad;
use App\Union;
use App\Auditoriafeligresia;
use App\Http\Requests\AsociacionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AsociacionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $asociaciones = Asociacion::all();
        $asociaciones->each(function($item) {
            $item->ciudad;
            $item->union;
        });
        return view('feligresia.estructura_eclesiastica.asociaciones.list')
                        ->with('location', 'feligresia')
                        ->with('asociaciones', $asociaciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $uniones = Union::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.asociaciones.create')
                        ->with('location', 'feligresia')
                        ->with('ciudades', $ciudades)
                        ->with('uniones', $uniones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsociacionRequest $request) {
        $asociacion = new Asociacion($request->all());
        foreach ($asociacion->attributesToArray() as $key => $value) {
            $asociacion->$key = strtoupper($value);
        }
        $result = $asociacion->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ASOCIACIÓN. DATOS: ";
            foreach ($asociacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La asociación <strong>" . $asociacion->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('asociacion.index');
        } else {
            flash("La asociación <strong>" . $asociacion->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('asociacion.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asociacion  $asociacion
     * @return \Illuminate\Http\Response
     */
    public function show(Asociacion $asociacion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asociacion  $asociacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $asociacion = Asociacion::find($id);
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $uniones = Union::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.asociaciones.edit')
                        ->with('location', 'feligresia')
                        ->with('asociacion', $asociacion)
                        ->with('ciudades', $ciudades)
                        ->with('uniones', $uniones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asociacion  $asociacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $asociacion = Asociacion::find($id);
        $m = new Asociacion($asociacion->attributesToArray());
        foreach ($asociacion->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $asociacion->$key = strtoupper($request->$key);
            }
        }
        $result = $asociacion->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE ASOCIACIÓN. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($asociacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La asociación <strong>" . $asociacion->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('asociacion.index');
        } else {
            flash("La asociación <strong>" . $asociacion->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('asociacion.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asociacion  $asociacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $asociacion = Asociacion::find($id);
        if (count($asociacion->zonas) > 0) {
            flash("La asociación <strong>" . $asociacion->nombre . "</strong> no pudo ser eliminada porque tiene zonas asociadas.")->warning();
            return redirect()->route('asociacion.index');
        } else {
            $result = $asociacion->delete();
            if ($result) {
                $aud = new Auditoriafeligresia();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE ASOCIACIÓN. DATOS ELIMINADOS: ";
                foreach ($asociacion->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La asociación <strong>" . $asociacion->nombre . "</strong> fue eliminada de forma exitosa!")->success();
                return redirect()->route('asociacion.index');
            } else {
                flash("La asociación <strong>" . $asociacion->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                return redirect()->route('asociacion.index');
            }
        }
    }

}
