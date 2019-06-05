<?php

namespace App\Http\Controllers;

use App\Iglesiamapa;
use Illuminate\Http\Request;
use App\Iglesia;
use Illuminate\Support\Facades\Auth;
use App\Auditoriacomunicacion;

class IglesiamapaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $iglesias = Iglesiamapa::all();
        return view('comunicaciones.iglesiamapa.list')
                        ->with('location', 'comunicacion')
                        ->with('iglesias', $iglesias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $iglesias = Iglesia::all();
        return view('comunicaciones.iglesiamapa.create')
                        ->with('location', 'comunicacion')
                        ->with('iglesias', $iglesias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $mapa = new Iglesiamapa($request->all());
        $u = Auth::user();
        $result = $mapa->save();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE MAPA. DATOS: ";
            foreach ($mapa->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El mapa fue almacenado de forma exitosa!")->success();
            return redirect()->route('iglesiamapa.index');
        } else {
            flash("El mapa no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('iglesiamapa.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Iglesiamapa  $iglesiamapa
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $mapa = Iglesiamapa::find($id);
        return view('comunicaciones.iglesiamapa.show')
                        ->with('location', 'comunicacion')
                        ->with('mapa', $mapa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Iglesiamapa  $iglesiamapa
     * @return \Illuminate\Http\Response
     */
    public function edit(Iglesiamapa $iglesiamapa) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Iglesiamapa  $iglesiamapa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Iglesiamapa $iglesiamapa) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Iglesiamapa  $iglesiamapa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $mapa = Iglesiamapa::find($id);
        $result = $mapa->delete();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE MAPA DATOS ELIMINADOS: ";
            foreach ($mapa->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El mapa fue eliminado de forma exitosa!")->success();
            return redirect()->route('iglesiamapa.index');
        } else {
            flash("El mapa no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('iglesiamapa.index');
        }
    }

}
