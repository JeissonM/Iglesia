<?php

namespace App\Http\Controllers;

use App\Historia;
use App\Auditoriacomunicacion;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\HistoriaRequest;
use Illuminate\Http\Request;

class HistoriaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $historia = Historia::all();
        return view('comunicaciones.institucional.historia.list')
                        ->with('location', 'comunicacion')
                        ->with('historia', $historia);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('comunicaciones.institucional.historia.create')
                        ->with('location', 'comunicacion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HistoriaRequest $request) {
        $activo = Historia::where('actual', 'SI')->first();
        if ($request->actual == 'SI' && $activo != null) {
            flash("La historia <strong>" . $activo->id . "</strong> es la ACTUAL. Deshabilite primero la historia para poder crear una nueva con estado actual SI. Atención: ")->warning();
            return redirect()->route('historia.index');
        }
        $historia = new Historia($request->all());
        foreach ($historia->attributesToArray() as $key => $value) {
            if ($key != 'texto') {
                $historia->$key = strtoupper($value);
            } else {
                $historia->$key = $value;
            }
        }
        $result = $historia->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE HISTORIA. DATOS: ";
            foreach ($historia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La historia <strong>" . $historia->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('historia.index');
        } else {
            flash("La historia <strong>" . $historia->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('historia.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $historia = Historia::find($id);
        if ($historia->actual == 'SI') {
            $historia->actual = 'NO';
        } else {
            $activa = Historia::where('actual', 'SI')->first();
            if ($activa == null) {
                $historia->actual = 'SI';
            } else {
                flash("La Historia <strong>" . $activa->id . "</strong> es la ACTUAL. Deshabilite primero la historia para poder cambiar el estado. Atención: ")->warning();
                return redirect()->route('historia.index');
            }
        }
        $result = $historia->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CAMBIO DE ESTADO HISTORIA. DATOS: ";
            foreach ($historia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El cambio fue realizado de forma exitosa!")->success();
            return redirect()->route('historia.index');
        } else {
            flash("El cambio no pudo ser realizado. Error: " . $result)->error();
            return redirect()->route('historia.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $historia = Historia::find($id);
        return view('comunicaciones.institucional.historia.edit')
                        ->with('location', 'comunicacion')
                        ->with('historia', $historia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $historia = Historia::find($id);
        $m = new Historia($historia->attributesToArray());
        foreach ($historia->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key != 'texto') {
                    $historia->$key = strtoupper($request->$key);
                } else {
                    $historia->$key = $request->$key;
                }
            }
        }
        $result = $historia->save();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE HISTORIA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($historia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La historia <strong>" . $historia->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('historia.index');
        } else {
            flash("La historia <strong>" . $historia->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('historia.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Historia  $historia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $historia = Historia::find($id);
        $result = $historia->delete();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE HISTORIA. DATOS ELIMINADOS: ";
            foreach ($historia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La historia <strong>" . $historia->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('historia.index');
        } else {
            flash("La historia <strong>" . $historia->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('historia.index');
        }
    }

}
