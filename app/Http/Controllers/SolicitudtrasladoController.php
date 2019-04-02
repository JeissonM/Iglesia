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
            flash("<strong> Usted </strong> no se encuentra registrado(a)!")->warning();
            return redirect()->route('admin.feligresia');
        }
        $personanatural = Personanatural::where('persona_id', $persona->id)->first();
        if ($personanatural != null) {
            $feligres = Feligres::where('personanatural_id', $personanatural->id)->first();
        } else {
            flash("<strong>Usted </strong> no se encuentra registrada como persona natural!")->error();
            return redirect()->route('admin.feligresia');
        }
        if ($feligres == null) {
            flash("<strong>Usted </strong> no se encuentra registrada como feligres!")->error();
            return redirect()->route('admin.feligresia');
        }
        if ($feligres != null && $feligres->estado_actual == 'ACTIVO') {
            $solicitudes = Solicitudtraslado::where('iglesia_origen', $feligres->iglesia_id)->orWhere('iglesia_destino', $feligres->iglesia_id)->get();
            if ($solicitudes != null) {
                foreach ($solicitudes as $s) {
                    $io = Iglesia::find($s->iglesia_origen);
                    $id = Iglesia::find($s->iglesia_destino);
                    $ao = Actajunta::find($s->acta_origen);
                    $ad = Actajunta::find($s->acta_destino);
                    $s['io'] = $io->nombre;
                    $s['id'] = $id->nombre;
                    $s['ao'] = $ao->nombre;
                    $s['ad'] = $ad->nombre;
                }
            }
            return view('feligresia.feligresia.traslados.list')
                            ->with('location', 'feligresia')
                            ->with('solicitudes', $solicitudes);
        } else {
            flash("<strong>Usted </strong> no se encuentra activo!")->error();
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
