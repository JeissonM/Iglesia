<?php

namespace App\Http\Controllers;

use App\Zona;
use App\Ciudad;
use App\Asociacion;
use App\Auditoriafeligresia;
use App\Http\Requests\ZonaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ZonaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $zonas = Zona::all();
        $zonas->each(function($item) {
            $item->ciudad;
            $item->zona;
        });
        return view('feligresia.estructura_eclesiastica.zonas.list')
                        ->with('location', 'feligresia')
                        ->with('zonas', $zonas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.zonas.create')
                        ->with('location', 'feligresia')
                        ->with('ciudades', $ciudades)
                        ->with('asociaciones', $asociaciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ZonaRequest $request) {
        $zona = new Zona($request->all());
        foreach ($zona->attributesToArray() as $key => $value) {
            if ($key == 'sitioweb') {
                $zona->$key = $value;
            } else {
                $zona->$key = strtoupper($value);
            }
        }
        $result = $zona->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ZONA. DATOS: ";
            foreach ($zona->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $zona->ciudad->nombre;
                } else if ($key == 'asociacion_id') {
                    $str = $str . ", " . $key . ": " . $value . ", asociacion:" . $zona->asociacion->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La zona <strong>" . $zona->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('zona.index');
        } else {
            flash("La zona <strong>" . $zona->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('zona.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function show(Zona $zona) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $zona = Zona::find($id);
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.zonas.edit')
                        ->with('location', 'feligresia')
                        ->with('zona', $zona)
                        ->with('ciudades', $ciudades)
                        ->with('asociaciones', $asociaciones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $zona = Zona::find($id);
        $m = new Zona($zona->attributesToArray());
        foreach ($zona->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key == 'sitioweb') {
                    $zona->$key = $request->$key;
                } else {
                    $zona->$key = strtoupper($request->$key);
                }
            }
        }
        $result = $zona->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE ZONA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", ciudad:" . $m->ciudad->nombre;
                } elseif ($key == 'asociacion_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", asociacion:" . $m->asociacion->nombre;
                } else {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
            }
            foreach ($zona->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $zona->ciudad->nombre;
                } else if ($key == 'asociacion_id') {
                    $str = $str . ", " . $key . ": " . $value . ", asociacion:" . $zona->asociacion->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La zona <strong>" . $zona->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('zona.index');
        } else {
            flash("La zona <strong>" . $zona->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('zona.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $zona = Zona::find($id);
        if (count($zona->distritos) > 0 || count($zona->iglesias) > 0) {
            flash("La zona <strong>" . $zona->nombre . "</strong> no pudo ser eliminada porque tiene distritos ó iglesias asociados.")->warning();
            return redirect()->route('zona.index');
        } else {
            $result = $zona->delete();
            if ($result) {
                $aud = new Auditoriafeligresia();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE ZONA. DATOS ELIMINADOS: ";
                foreach ($zona->attributesToArray() as $key => $value) {
                    if ($key == 'ciudad_id') {
                        $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $zona->ciudad->nombre;
                    } else if ($key == 'asociacion_id') {
                        $str = $str . ", " . $key . ": " . $value . ", asociacion:" . $zona->asociacion->nombre;
                    } else {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La zona <strong>" . $zona->nombre . "</strong> fue eliminada de forma exitosa!")->success();
                return redirect()->route('zona.index');
            } else {
                flash("La zona <strong>" . $zona->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                return redirect()->route('zona.index');
            }
        }
    }

}
