<?php

namespace App\Http\Controllers;

use App\Solicitudtraslado;
use App\Feligres;
use App\Persona;
use App\Personanatural;
use App\Actajunta;
use App\Iglesia;
use App\Pastor;
use App\Asociacion;
use App\Miembrojunta;
use App\Periodo;
use App\Junta;
use App\Reunionjunta;
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
                    $s['ide'] = $id->nombre;
                    if ($ao != null) {
                        $s['ao'] = $ao->documento;
                    }
                    if ($ad != null) {
                        $s['ad'] = $ad->documento;
                    }
                }
            }
            return view('feligresia.feligresia.traslados.list')
                            ->with('location', 'feligresia')
                            ->with('secretario', $feligres)
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
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        return view('feligresia.feligresia.traslados.create')
                        ->with('location', 'feligresia')
                        ->with('asociaciones', $asociaciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitudtrasladoRequest $request) {
        $solicitud = new Solicitudtraslado($request->all());
        foreach ($solicitud->attributesToArray() as $key => $value) {
            $solicitud->$key = strtoupper($value);
        }
        $solicitud->tiposolicitud = 'SOLICITAR';
        $result = $solicitud->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE SOLICITUD DE TRASLADO. DATOS: ";
            foreach ($solicitud->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La solicitud del feligres <strong>" . $solicitud->feligres->personanatural->primer_nombre . " " . $solicitud->feligres->personanatural->primer_apellido . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('solicitud.index');
        } else {
            flash("La solicitud del feligres <strong>" . $solicitud->feligres->personanatural->primer_nombre . " " . $solicitud->feligres->personanatural->apellido_apellido . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('solicitud.index');
        }
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
    public function update(Request $request, $id) {
        $solicitud = Solicitudtraslado::find($id);
        $m = new Solicitudtraslado($solicitud->attributesToArray());
        foreach ($solicitud->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $solicitud->$key = strtoupper($request->$key);
            }
        }
        $result = $solicitud->save();
        if ($result) {
            if ($request->estado == 'ACEPTADA') {
                $iglesiao = Iglesia::find($solicitud->iglesia_origen);
                $feligres = Feligres::find($solicitud->feligres_id);
                $feligres->distrito_origen = $iglesiao->distrito_id;
                $feligres->asociacion_origen = $iglesiao->distrito->asociacion_id;
                $feligres->iglesia_origen = $iglesiao->id;
                $feligres->iglesia_id = null;
                $feligres->save();
            }
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "PROCESO DE SOLICITUD DE TRASLADO: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($solicitud->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La solicitud del feligres <strong>" . $solicitud->feligres->personanatural->primer_nombre . " " . $solicitud->feligres->personanatural->primer_apellido . "</strong> fue procesada de forma exitosa!")->success();
            return redirect()->route('solicitud.index');
        } else {
            flash("La solicitud del feligres <strong>" . $solicitud->feligres->personanatural->primer_nombre . " " . $solicitud->feligres->personanatural->apellido_apellido . "</strong> no pudo ser procesada. Error: " . $result)->error();
            return redirect()->route('solicitud.index');
        }
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

    /**
     * show all resource from a identificacion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getfeligres($id) {
        $persona = Persona::where('numero_documento', $id)->first();
        if ($persona == null) {
            return "null";
        }
        $personanatural = Personanatural::where('persona_id', $persona->id)->first();
        if ($personanatural == null) {
            return "null";
        }
        $feligres = Feligres::where('personanatural_id', $personanatural->id)->first();
        if ($feligres != null) {
            $obj["id"] = $feligres->id;
            $obj["identificacion"] = $feligres->personanatural->persona->numero_documento;
            $obj["nombre"] = $personanatural->primer_nombre . " " . $personanatural->segundo_nombre . " " . $personanatural->primer_apellido . " " . $personanatural->segundo_apellido;
            return json_encode($obj);
        } else {
            return "null";
        }
    }

    /*
     * devuelve las reuniones de junta para un periodo e iglesia
     * 
     * @params {periodo,iglesia}
     * @return \Illuminate\Http\Response
     */

    public function getactas($per, $igle) {
        $junta = Junta::where([['iglesia_id', $igle], ['periodo_id', $per]])->first();
        if ($junta != null) {
            $reunion = Reunionjunta::where('junta_id', $junta->id)->get();
            if (count($reunion) > 0) {
                $reuniones = null;
                foreach ($reunion as $value) {
                    $obj["id"] = $value->actajunta_id;
                    $obj["value"] = $value->titulo . " - " . $value->fecha;
                    $reuniones[] = $obj;
                }
                return json_encode($reuniones);
            } else {
                return "null";
            }
        } else {
            return "null";
        }
    }

    /*
     * procesa las solicitudes que le hacen a mi iglesia
     * 
     * @params {id}
     * @return \Illuminate\Http\Response
     */

    public function procesar($id) {
        $solicitud = Solicitudtraslado::find($id);
        $solicitud->estado = 'EN ESTUDIO';
        $solicitud->save();
        $iglesiadestino = Iglesia::find($solicitud->iglesia_destino);
        $pastord = Pastor::where('distrito_id', $iglesiadestino->distrito_id)->first();
        $feligres = Feligres::find($solicitud->feligres_id);
        $miembrojunta = Miembrojunta::where('feligres_id', $feligres->id)->get();
        $periodos = Periodo::all()->pluck('etiqueta', 'id');
        $historialsoli = Solicitudtraslado::where('feligres_id', $feligres->id)->get();
        if ($historialsoli != null) {
            foreach ($historialsoli as $h) {
                $io = Iglesia::find($h->iglesia_origen);
                $id = Iglesia::find($h->iglesia_destino);
                $h['io'] = $io->nombre;
                $h['ide'] = $id->nombre;
            }
        }
        return view('feligresia.feligresia.traslados.procesar')
                        ->with('location', 'feligresia')
                        ->with('iglesiadestino', $iglesiadestino)
                        ->with('pastord', $pastord)
                        ->with('f', $feligres)
                        ->with('miembrojunta', $miembrojunta)
                        ->with('historialsoli', $historialsoli)
                        ->with('periodos', $periodos)
                        ->with('solicitud', $solicitud);
    }

}
