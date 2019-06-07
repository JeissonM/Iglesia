<?php

namespace App\Http\Controllers;

use App\Agendaasociacion;
use App\Asociacion;
use App\Periodo;
use App\Auditoriacomunicacion;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AgendaasociacionRequest;
use Illuminate\Http\Request;

class AgendaasociacionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $agendas = Agendaasociacion::all();
        return view('comunicaciones.agenda_asociacion.list')
                        ->with('location', 'comunicacion')
                        ->with('agendas', $agendas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        $periodos = Periodo::all()->pluck('etiqueta', 'id');
        return view('comunicaciones.agenda_asociacion.create')
                        ->with('location', 'comunicaciones')
                        ->with('asociaciones', $asociaciones)
                        ->with('periodos', $periodos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgendaasociacionRequest $request) {
        $activo = Agendaasociacion::where('estado', 'ACTIVA')->first();
        if ($activo != null) {
            flash("La agenda <strong>" . $activo->id . "</strong> esta ACTIVA. Deshabilite primero la agenda para poder crear una nueva. Atención: ")->warning();
            return redirect()->route('agendaasociacion.index');
        }
        $agenda = new Agendaasociacion($request->all());
        foreach ($agenda->attributesToArray() as $key => $value) {
            $agenda->$key = strtoupper($value);
        }
        if (isset($request->documento)) {
            $file = $request->file("documento");
            $hoy = getdate();
            $name = "Documento_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/agenda/";
            $file->move($path, $name);
            $agenda->documento = $name;
        } else {
            $agenda->documento = "no";
        }
        $agenda->estado = 'ACTIVA';
        $result = $agenda->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE AGENDA ASOCIACIÓN. DATOS: ";
            foreach ($agenda->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La agenda <strong>" . $agenda->id . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('agendaasociacion.index');
        } else {
            flash("La agenda <strong>" . $agenda->id . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('agendaasociacion.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agendaasociacion  $agendaasociacion
     * @return \Illuminate\Http\Response
     */
    public function show(Agendaasociacion $agendaasociacion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agendaasociacion  $agendaasociacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $agenda = Agendaasociacion::find($id);
        return view('comunicaciones.agenda_asociacion.edit')
                        ->with('location', 'comunicaciones')
                        ->with('agenda', $agenda);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agendaasociacion  $agendaasociacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $agenda = Agendaasociacion::find($request->id);
        if (isset($request->documento)) {
            if (unlink(public_path() . "/docs/agenda/" . $agenda->documento)) {
                $file = $request->file("documento");
                $hoy = getdate();
                $name = "Documento_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/agenda/";
                $file->move($path, $name);
                $agenda->documento = $name;
            } else {
                flash("El documento no pudo ser modificada. Error: ")->error();
                return redirect()->route('agendaasociacion.edit', $request->id);
            }
        } else {
            flash("El documento no pudo ser modificado, porque no se encontro ningun documento. Error: ")->error();
            return redirect()->route('agendaasociacion.edit', $request->id);
        }
        $result = $agenda->save();
        if ($result) {
            flash("El documento fue modificado de forma exitosa!")->success();
            return redirect()->route('agendaasociacion.edit', $request->id);
        } else {
            flash("El documento no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('agendaasociacion.edit', $request->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agendaasociacion  $agendaasociacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $agenda = Agendaasociacion::find($id);
//        if (count($agenda->itinerariodetalles) > 0) {
//            flash("El evento <strong>" . $agenda->titulo . "</strong> no pudo ser eliminado porque tiene detalles asociados.")->warning();
//            return redirect()->route('itinerario.index');
//        } else {
            $result = $agenda->delete();
            if ($result) {
                unlink(public_path() . "/docs/agenda/" . $agenda->documento);
                $aud = new Auditoriacomunicacion();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE AGENDA ASOCIACIÓN DATOS ELIMINADOS: ";
                foreach ($agenda->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La agenda <strong>" . $agenda->id . "</strong> fue eliminada de forma exitosa!")->success();
                return redirect()->route('agendaasociacion.index');
            } else {
                flash("La agenda <strong>" . $agenda->id . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                return redirect()->route('agendaasociacion.index');
            }
        //}
    }

    /**
     * Cambia el estado de una agenda activa a inactiva
     * @param \App\Agendaasociacion  $agendaasociacion
     *  @return \Illuminate\Http\Response
     */
    public function estado($id) {
        $agenda = Agendaasociacion::find($id);
        $agenda->estado = 'INACTIVA';
        $result = $agenda->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CAMBIO DE ESTADO. DATOS: ";
            foreach ($agenda->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El cambio fue realizado de forma exitosa!")->success();
            return redirect()->route('agendaasociacion.index');
        } else {
            flash("El cambio no pudo ser realizado. Error: " . $result)->error();
            return redirect()->route('agendaasociacion.index');
        }
    }

}
