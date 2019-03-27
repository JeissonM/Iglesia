<?php

namespace App\Http\Controllers;

use App\Ciudad;
use App\Estado;
use App\Auditoriafeligresia;
use App\Http\Requests\CiudadRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CiudadController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $ciudades = Ciudad::all();
        $ciudades->each(function ($ciudad) {
            $ciudad->estado;
        });
        return view('feligresia.datos_geograficos.ciudades.list')
                        ->with('location', 'feligresia')
                        ->with('ciudades', $ciudades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $estados = Estado::all()->pluck('nombre', 'id');
        return view('feligresia.datos_geograficos.ciudades.create')
                        ->with('location', 'feligresia')
                        ->with('estados', $estados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CiudadRequest $request) {
        $ciudad = new Ciudad($request->all());
        foreach ($ciudad->attributesToArray() as $key => $value) {
            $ciudad->$key = strtoupper($value);
        }
        $result = $ciudad->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CIUDAD. DATOS: ";
            foreach ($ciudad->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('ciudad.index');
        } else {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('ciudad.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ciudad  $ciudad
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ciudad  $ciudad
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $ciudad = Ciudad::find($id);
        $estados = Estado::all()->pluck('nombre', 'id');
        return view('feligresia.datos_geograficos.ciudades.edit')
                        ->with('location', 'feligresia')
                        ->with('ciudad', $ciudad)
                        ->with('estados', $estados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ciudad  $ciudad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $ciudad = Ciudad::find($id);
        $m = new Ciudad($ciudad->attributesToArray());
        foreach ($ciudad->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $ciudad->$key = strtoupper($request->$key);
            }
        }
        $result = $ciudad->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE CIUDAD. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($ciudad->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('ciudad.index');
        } else {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('ciudad.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ciudad  $ciudad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $ciudad = Ciudad::find($id);
        $result = $ciudad->delete();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE CIUDAD. DATOS ELIMINADOS: ";
            foreach ($ciudad->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('ciudad.index');
        } else {
            flash("La Ciudad <strong>" . $ciudad->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('ciudad.index');
        }
    }

}
