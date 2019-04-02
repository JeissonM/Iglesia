<?php

namespace App\Http\Controllers;

use App\Junta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use App\Periodo;

class JuntaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p !== null) {
            $pn = Personanatural::where('persona_id', $p->id)->first();
            if ($pn !== null) {
                $f = Feligres::where([['personanatural_id', $pn->id], ['estado_actual', 'ACTIVO']])->first();
                if ($f !== null) {
                    $per = Periodo::all();
                    $periodos = null;
                    foreach ($per as $pe) {
                        $periodos[$pe->id] = $pe->etiqueta . " - " . $pe->fechainicio . " - " . $pe->fechafin;
                    }
                    return view('feligresia.ministerios.junta.list')
                                    ->with('location', 'feligresia')
                                    ->with('f', $f)
                                    ->with('periodos', $periodos);
                } else {
                    flash('No tiene permisos para acceder a esta función.')->warning();
                    return redirect()->route();
                }
            } else {
                flash('No tiene permisos para acceder a esta función.')->warning();
                return redirect()->route();
            }
        } else {
            flash('No tiene permisos para acceder a esta función.')->warning();
            return redirect()->route();
        }
    }

    /*
     * muestra menu de junta
     */

    public function continuar(Request $request) {
        $f = Feligres::find($request->feligres_id);
        $p = Periodo::find($request->periodo_id);
        $junta = Junta::where([['iglesia_id', $f->iglesia_id], ['periodo_id', $p->id], ['vigente', 'SI']])->first();
        return view('feligresia.ministerios.junta.continuar')
                        ->with('location', 'feligresia')
                        ->with('f', $f)
                        ->with('p', $p)
                        ->with('junta', $junta);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function show(Junta $junta) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function edit(Junta $junta) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Junta $junta) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Junta $junta) {
        //
    }

}
