<?php

namespace App\Http\Controllers;

use App\Mision;
use App\Auditoriacomunicacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MisionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $mision = Mision::all();
        return view('comunicaciones.institucional.mision.list')
                        ->with('location', 'comunicacion')
                        ->with('mision', $mision);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('comunicaciones.institucional.mision.create')
                        ->with('location', 'comunicacion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $activo = Mision::where('actual', 'SI')->first();
        if ($request->actual == 'SI' && $activo != null) {
            flash("La Misión <strong>" . $activo->id . "</strong> es la ACTUAL. Deshabilite primero la misión para poder crear una nueva. Atención: ")->warning();
            return redirect()->route('mision.index');
        }
        $mision = new Mision($request->all());
        foreach ($mision->attributesToArray() as $key => $value) {
            $mision->$key = strtoupper($value);
        }
        $result = $mision->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE MISION. DATOS: ";
            foreach ($mision->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La misión <strong>" . $mision->id . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('mision.index');
        } else {
            flash("La misión <strong>" . $mision->id . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('mision.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mision  $mision
     * @return \Illuminate\Http\Response
     */
    public function show(Mision $mision) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mision  $mision
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $mision = Mision::find($id);
        if ($mision->actual == 'SI') {
            $mision->actual = 'NO';
        } else {
            $activa = Mision::where('actual', 'SI')->first();
            if ($activa == null) {
                $mision->actual = 'SI';
            } else {
                flash("La Misión <strong>" . $activa->id . "</strong> es la ACTUAL. Deshabilite primero la misión para poder cambiar el estado. Atención: ")->warning();
                return redirect()->route('mision.index');
            }
        }
        $result = $mision->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CAMBIO DE ESTADO MISIÓN. DATOS: ";
            foreach ($mision->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El cambio fue realizado de forma exitosa!")->success();
            return redirect()->route('mision.index');
        } else {
            flash("El cambio no pudo ser realizado. Error: " . $result)->error();
            return redirect()->route('mision.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mision  $mision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mision $mision) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mision  $mision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $mision = Mision::find($id);
        $result = $mision->delete();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE MISION DATOS ELIMINADOS: ";
            foreach ($mision->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La misión <strong>" . $mision->id . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('mision.index');
        } else {
            flash("La misión <strong>" . $mision->id . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('mision.index');
        }
    }

}
