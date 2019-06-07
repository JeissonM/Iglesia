<?php

namespace App\Http\Controllers;

use App\Vision;
use App\Auditoriacomunicacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VisionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $vision = Vision::all();
        return view('comunicaciones.institucional.vision.list')
                        ->with('location', 'comunicacion')
                        ->with('vision', $vision);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('comunicaciones.institucional.vision.create')
                        ->with('location', 'comunicacion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $activo = Vision::where('actual', 'SI')->first();
        if ($request->actual == 'SI' && $activo != null) {
            flash("La visión <strong>" . $activo->id . "</strong> es la ACTUAL. Deshabilite primero la visión para poder crear una nueva. Atención: ")->warning();
            return redirect()->route('vision.index');
        }
        $vision = new Vision($request->all());
        foreach ($vision->attributesToArray() as $key => $value) {
            $vision->$key = strtoupper($value);
        }
        $result = $vision->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE VISION. DATOS: ";
            foreach ($vision->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La visión <strong>" . $vision->id . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('vision.index');
        } else {
            flash("La visión <strong>" . $vision->id . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('vision.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vision  $vision
     * @return \Illuminate\Http\Response
     */
    public function show(Vision $vision) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vision  $vision
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $vision = Vision::find($id);
        if ($vision->actual == 'SI') {
            $vision->actual = 'NO';
        } else {
            $activa = Vision::where('actual', 'SI')->first();
            if ($activa == null) {
                $vision->actual = 'SI';
            } else {
                flash("La Visión <strong>" . $activa->id . "</strong> es la ACTUAL. Deshabilite primero la misión para poder cambiar el estado. Atención: ")->warning();
                return redirect()->route('vision.index');
            }
        }
        $result = $vision->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CAMBIO DE ESTADO VISIÓN. DATOS: ";
            foreach ($vision->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El cambio fue realizado de forma exitosa!")->success();
            return redirect()->route('vision.index');
        } else {
            flash("El cambio no pudo ser realizado. Error: " . $result)->error();
            return redirect()->route('vision.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vision  $vision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vision $vision) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vision  $vision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $vision = Vision::find($id);
        $result = $vision->delete();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE VISION DATOS ELIMINADOS: ";
            foreach ($vision->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La visión <strong>" . $vision->id . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('vision.index');
        } else {
            flash("La visión <strong>" . $vision->id . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('vision.index');
        }
    }

}
