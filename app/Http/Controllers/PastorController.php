<?php

namespace App\Http\Controllers;

use App\Pastor;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use App\Ciudad;
use App\Pais;
use App\Estado;
use App\Iglesia;
use App\Distrito;
use App\Tipodocumento;
use App\Estadocivil;
use Illuminate\Http\Request;

class PastorController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pastores = Pastor::all();
        return view('feligresia.feligresia.pastores.list')
                        ->with('location', 'feligresia')
                        ->with('pastores', $pastores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $iglesias = Iglesia::all()->pluck('nombre', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $distritos = Distrito::all()->pluck('nombre', 'id');
        $estadosciviles = Estadocivil::all()->pluck('descripcion', 'id');
        $tiposdoc = Tipodocumento::all()->pluck('descripcion', 'id');
        return view('feligresia.feligresia.pastores.create')
                        ->with('location', 'feligresia')
                        ->with('iglesias', $iglesias)
                        ->with('estadosc', $estadosciviles)
                        ->with('paises', $paises)
                        ->with('distritos', $distritos)
                        ->with('tipodoc', $tiposdoc);
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
     * @param  \App\Pastor  $pastor
     * @return \Illuminate\Http\Response
     */
    public function show(Pastor $pastor) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pastor  $pastor
     * @return \Illuminate\Http\Response
     */
    public function edit(Pastor $pastor) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pastor  $pastor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pastor $pastor) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pastor  $pastor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pastor $pastor) {
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
        $iglesias = Iglesia::all()->pluck('nombre', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $distritos = Distrito::all()->pluck('nombre', 'id');
        $estadosciviles = Estadocivil::all()->pluck('descripcion', 'id');
        $tiposdoc = Tipodocumento::all()->pluck('descripcion', 'id');
        return view('feligresia.feligresia.pastores.create')
                        ->with('location', 'feligresia')
                        ->with('iglesias', $iglesias)
                        ->with('estadosc', $estadosciviles)
                        ->with('paises', $paises)
                        ->with('distritos', $distritos)
                        ->with('tipodoc', $tiposdoc);
    }

}
