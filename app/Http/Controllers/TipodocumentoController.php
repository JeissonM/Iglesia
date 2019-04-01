<?php

namespace App\Http\Controllers;

use App\Tipodocumento;
use App\Auditoriafeligresia;
use App\Http\Requests\TipodocumentoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TipodocumentoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tipos = Tipodocumento::all();
        return view('feligresia.feligresia.tipodoc.list')
                        ->with('location', 'feligresia')
                        ->with('tipos', $tipos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.feligresia.tipodoc.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipodocumentoRequest $request) {
        $tipo = new Tipodocumento($request->all());
        foreach ($tipo->attributesToArray() as $key => $value) {
            $tipo->$key = strtoupper($value);
        }
        $result = $tipo->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE TIPO DE DOCUMENTO. DATOS: ";
            foreach ($tipo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El tipo de documento <strong>" . $tipo->descripcion . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('tipodoc.index');
        } else {
            flash("El tipo de documento <strong>" . $tipo->descripcion . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('tipodoc.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tipodocumento  $tipodocumento
     * @return \Illuminate\Http\Response
     */
    public function show(Tipodocumento $tipodocumento) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tipodocumento  $tipodocumento
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $tipos = Tipodocumento::find($id);
        return view('feligresia.feligresia.tipodoc.edit')
                        ->with('location', 'feligresia')
                        ->with('tipo', $tipo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tipodocumento  $tipodocumento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipodocumento $tipodocumento) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tipodocumento  $tipodocumento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipodocumento $tipodocumento) {
        //
    }

}
