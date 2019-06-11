<?php

namespace App\Http\Controllers;

use App\Valor;
use App\Auditoriacomunicacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ValorController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $valor = Valor::all();
        return view('comunicaciones.institucional.valor.list')
                        ->with('location', 'comunicacion')
                        ->with('valor', $valor);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('comunicaciones.institucional.valor.create')
                        ->with('location', 'comunicacion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $valor = new Valor($request->all());
        foreach ($valor->attributesToArray() as $key => $value) {
            $valor->$key = strtoupper($value);
        }
        $result = $valor->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE VALOR. DATOS: ";
            foreach ($valor->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El valor <strong>" . $valor->valor . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('valor.index');
        } else {
            flash("El valor <strong>" . $valor->valor . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('valor.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Valor  $valor
     * @return \Illuminate\Http\Response
     */
    public function show(Valor $valor) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Valor  $valor
     * @return \Illuminate\Http\Response
     */
    public function edit(Valor $valor) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Valor  $valor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valor $valor) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Valor  $valor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $valor = Valor::find($id);
        $result = $valor->delete();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE VALOR DATOS ELIMINADOS: ";
            foreach ($valor->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El valor <strong>" . $valor->valor . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('valor.index');
        } else {
            flash("El valor <strong>" . $valor->valor . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('valor.index');
        }
    }

}
