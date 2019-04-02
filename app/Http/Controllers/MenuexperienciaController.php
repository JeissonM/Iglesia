<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Personanatural;
use App\Feligres;

class MenuexperienciaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    /**
     * Show the form for make operations width a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function operaciones() {
        $persona = Persona::where('numero_documento', $_POST["id"])->first();
        if ($persona == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada!")->error();
            return redirect()->route('pastor.index');
        }
        $personanatural = Personanatural::where('persona_id', $persona->id)->first();
        if ($personanatural != null) {
            $feligres = Feligres::where('personanatural_id', $personanatural->id)->first();
        } else {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como persona natural!")->error();
            return redirect()->route('pastor.index');
        }
        if ($feligres == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como feligres!")->error();
            return redirect()->route('pastor.index');
        }
        $feligres->personanatural;
        return view('feligresia.feligresia.experiencia.menu')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres);
    }

}
