<?php

namespace App\Http\Controllers;

use App\Disciplina;
use Illuminate\Http\Request;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use App\Periodo;
use App\Auditoriafeligresia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DisciplinaRequest;

class DisciplinaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
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
    public function store(DisciplinaRequest $request) {
        $d = new Disciplina($request->all());
        $f = Feligres::find($request->feligres_id);
        if ($d->save()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE DISCIPLINA. DATOS: ";
            foreach ($d->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La disciplina fue aplicada de forma exitosa!")->success();
            return redirect()->route('disciplina.inicio', $f->personanatural->persona->numero_documento);
        } else {
            flash("La disciplina no pudo ser aplicada.")->error();
            return redirect()->route('disciplina.inicio', $f->personanatural->persona->numero_documento);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function show(Disciplina $disciplina) {
        $disciplina->feligres;
        $disciplina->reunionjunta;
        $disciplina->periodo;
        return view('feligresia.feligresia.disciplina.show')
                        ->with('location', 'feligresia')
                        ->with('d', $disciplina);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function edit(Disciplina $disciplina) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disciplina $disciplina) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $d = Disciplina::find($id);
        $result = $d->delete();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE DISCIPLINA. DATOS ELIMINADOS: ";
            foreach ($d->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La disciplina fue retirada de forma exitosa!")->success();
            return redirect()->route('disciplina.inicio', $d->feligres->personanatural->persona->numero_documento);
        } else {
            flash("La disciplina no pudo ser retirada.")->error();
            return redirect()->route('disciplina.inicio', $d->feligres->personanatural->persona->numero_documento);
        }
    }

    public function inicio($id) {
        $feligres = null;
        $persona = Persona::where('numero_documento', $id)->first();
        if ($persona == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada!")->error();
            return redirect()->route('admin.feligresia');
        }
        $personanatural = Personanatural::where('persona_id', $persona->id)->first();
        if ($personanatural != null) {
            $feligres = Feligres::where('personanatural_id', $personanatural->id)->first();
        } else {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como persona natural!")->error();
            return redirect()->route('admin.feligresia');
        }
        if ($feligres == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como feligres!")->error();
            return redirect()->route('admin.feligresia');
        }
        $feligres->personanatural;
        $feligres->disciplinas;
        $per = Periodo::all()->sortByDesc('id');
        return view('feligresia.feligresia.disciplina.list')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres)
                        ->with('periodos', $per);
    }

}
