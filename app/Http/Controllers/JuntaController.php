<?php

namespace App\Http\Controllers;

use App\Junta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use App\Periodo;
use App\Iglesia;
use App\Pastor;
use App\Auditoriafeligresia;

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
                    return redirect()->route('admin.feligresia');
                }
            } else {
                flash('No tiene permisos para acceder a esta función.')->warning();
                return redirect()->route('admin.feligresia');
            }
        } else {
            flash('No tiene permisos para acceder a esta función.')->warning();
            return redirect()->route('admin.feligresia');
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
        $f = Feligres::find($request->feligres_id);
        $p = Periodo::find($request->periodo_id);
        $juntaold = Junta::where([['iglesia_id', $f->iglesia_id], ['vigente', 'SI']])->first();
        if ($juntaold !== null) {
            flash('Hay una junta vigente en otro período, haga el cierre de dicha junta para crear una nueva.')->warning();
            return redirect()->route('junta.index');
        }
        $iglesia = Iglesia::find($f->iglesia_id);
        $pastor = Pastor::where('distrito_id', $iglesia->distrito_id)->first();
        $j = new Junta();
        $j->etiqueta = strtoupper($request->etiqueta);
        $j->vigente = "SI";
        $j->iglesia_id = $f->iglesia_id;
        $j->pastor_id = $pastor->id;
        $j->periodo_id = $p->id;
        if ($j->save()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE JUNTA. DATOS: ";
            foreach ($j->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La junta fue almacenada de forma exitosa!")->success();
            return redirect()->route('junta.index');
        } else {
            flash("La junta no pudo ser almacenada.")->error();
            return redirect()->route('junta.index');
        }
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
    public function destroy($id) {
        $junta = Junta::find($id);
        if (count($junta->miembrojuntas) > 0) {
            flash("La junta no pudo ser eliminada, tiene miembros asociados.")->error();
            return redirect()->route('junta.index');
        }
        if ($junta->delete()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE JUNTA. DATOS: ";
            foreach ($junta->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La junta fue eliminada con exito.")->success();
            return redirect()->route('junta.index');
        } else {
            flash("La junta no pudo ser eliminada.")->error();
            return redirect()->route('junta.index');
        }
    }

    /*
     * permite gestionar los miembros de una junta
     */

    public function miembros($f, $p, $j) {
        $feligres = Feligres::find($f);
        $periodo = Periodo::find($p);
        $junta = Junta::find($j);
        $junta->miembrojuntas;
        return view('feligresia.ministerios.junta.miembros')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres)
                        ->with('p', $periodo)
                        ->with('j', $junta);
    }

}
