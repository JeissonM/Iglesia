<?php

namespace App\Http\Controllers;

use App\Seguimientoubucacion;
use Illuminate\Http\Request;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use App\Iglesia;

class SeguimientoubucacionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
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
        $tras = $feligres->solicitudtraslados;
        if (count($tras) > 0) {
            foreach ($tras as $t) {
                $t->origen = Iglesia::find($t->iglesia_origen);
                $t->destino = Iglesia::find($t->iglesia_destino);
            }
        }
        return view('feligresia.feligresia.ubicacion.list')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres)
                        ->with('tras', $tras);
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
     * @param  \App\Seguimientoubucacion  $seguimientoubucacion
     * @return \Illuminate\Http\Response
     */
    public function show(Seguimientoubucacion $seguimientoubucacion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seguimientoubucacion  $seguimientoubucacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Seguimientoubucacion $seguimientoubucacion) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seguimientoubucacion  $seguimientoubucacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seguimientoubucacion $seguimientoubucacion) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seguimientoubucacion  $seguimientoubucacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seguimientoubucacion $seguimientoubucacion) {
        //
    }

}
