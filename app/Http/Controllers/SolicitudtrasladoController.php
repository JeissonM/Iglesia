<?php

namespace App\Http\Controllers;

use App\Solicitudtraslado;
use App\Feligres;
use App\Persona;
use App\Personanatural;
use App\Actajunta;
use App\Iglesia;
use App\Auditoriafeligresia;
use App\Http\Requests\SolicitudtrasladoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SolicitudtrasladoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $persona = Persona::where('numero_documento', $u->identificacion)->first();
        if ($persona == null) {
            flash("<strong> Usted </strong> no se encuentra registrado(a)!")->error();
            return redirect()->route('admin.feligresia');
        }
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
     * @param  \App\Solicitudtraslado  $solicitudtraslado
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitudtraslado $solicitudtraslado) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Solicitudtraslado  $solicitudtraslado
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitudtraslado $solicitudtraslado) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Solicitudtraslado  $solicitudtraslado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitudtraslado $solicitudtraslado) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Solicitudtraslado  $solicitudtraslado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Solicitudtraslado $solicitudtraslado) {
        //
    }

}
