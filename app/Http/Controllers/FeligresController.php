<?php

namespace App\Http\Controllers;

use App\Feligres;
use Illuminate\Http\Request;
use App\Http\Requests\FeligresRequest;
use Illuminate\Support\Facades\Auth;
use App\Iglesia;
use App\Pais;
use App\Estadocivil;
use App\Tipodocumento;
use App\Asociacion;
use App\Persona;
use App\Personanatural;
use App\Auditoriafeligresia;

class FeligresController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $feligreses = Feligres::all();
        return view('feligresia.feligresia.feligres.list')
                        ->with('location', 'feligresia')
                        ->with('feligreses', $feligreses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $estadosciviles = Estadocivil::all()->pluck('descripcion', 'id');
        $tiposdoc = Tipodocumento::all()->pluck('descripcion', 'id');
        return view('feligresia.feligresia.feligres.create')
                        ->with('location', 'feligresia')
                        ->with('asociaciones', $asociaciones)
                        ->with('estadosc', $estadosciviles)
                        ->with('paises', $paises)
                        ->with('tipodoc', $tiposdoc);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeligresRequest $request) {
        $p = $this->setPersona('NATURAL', $request->direccion, $request->email, $request->celular, $request->telefono, $request->numero_documento, $request->lugar_expedicion, $request->fecha_expedicion, 'NO', 'NO', $request->tipodocumento_id, $request->paisr_id, $request->estador_id, $request->ciudadr_id);
        if ($p->save()) {
            $pn = $this->setPersonanatural($request->primer_nombre, $request->segundo_nombre, $request->sexo, $request->fecha_nacimiento, $request->libreta_militar, $request->edad, $request->rh, $request->primer_apellido, $request->segundo_apellido, $request->distrito_militar, $request->numero_pasaporte, $request->otra_nacionalidad, $request->clase_libreta, 'NO', $request->padre, $request->madre, $request->ocupacion, $request->profesion, $request->nivel_estudio, $request->ultimo_grado, $request->religion_anterior, $request->ciudad_id, $request->estado_id, $request->pais_id, $p->id);
            if ($pn->save()) {
                $f = $this->setFeligres($request->aceptado_por, null, $request->pastor_oficiante, $request->estado_actual, $request->fecha_bautismo, $request->asociacion_origen, $request->distrito_origen, $request->iglesia_origen, $request->asociacion_destino, $request->distrito_destino, $request->iglesia_destino, $pn->id);
                if ($f->save()) {
                    $this->setAuditoria($p->attributesToArray(), 'INSERTAR', 'CREACIÓN DE PERSONA, DATOS:');
                    $this->setAuditoria($pn->attributesToArray(), 'INSERTAR', 'CREACIÓN DE PERSONA NATURAL, DATOS:');
                    $this->setAuditoria($f->attributesToArray(), 'INSERTAR', 'CREACIÓN DE FELIGRÉS, DATOS:');
                    flash("La persona</strong> fue almacenada con exito.")->success();
                    return redirect()->route('feligres.index');
                } else {
                    $pn->delete();
                    $p->delete();
                    flash("La persona</strong> no pudo ser almacenada.")->error();
                    return redirect()->route('feligres.index');
                }
            } else {
                $p->delete();
                flash("La persona</strong> no pudo ser almacenada.")->error();
                return redirect()->route('feligres.index');
            }
        } else {
            flash("La persona</strong> no pudo ser almacenada.")->error();
            return redirect()->route('feligres.index');
        }
    }

    /*
     * auditoria
     */

    public function setAuditoria($array, $operacion, $strs) {
        $aud = new Auditoriafeligresia();
        $u = Auth::user();
        $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
        $aud->operacion = $operacion;
        $str = $strs;
        foreach ($array as $key => $value) {
            $str = $str . ", " . $key . ": " . $value;
        }
        $aud->detalles = $str;
        $aud->save();
    }

    /*
     * llena una persona
     */

    public function setPersona($tipopersona, $direccion, $mail, $celular, $telefono, $numero_documento, $lugar_expedicion, $fecha_expedicion, $nombrecomercial, $regimen, $tipodocumento_id, $pais_id, $estado_id, $ciudad_id) {
        $p = new Persona();
        $p->tipopersona = $tipopersona;
        $p->direccion = strtoupper($direccion);
        $p->mail = $mail;
        $p->celular = $celular;
        $p->telefono = $telefono;
        $p->numero_documento = $numero_documento;
        $p->lugar_expedicion = strtoupper($lugar_expedicion);
        $p->fecha_expedicion = $fecha_expedicion;
        $p->nombrecomercial = strtoupper($nombrecomercial);
        $p->regimen = strtoupper($regimen);
        $p->tipodocumento_id = $tipodocumento_id;
        $p->pais_id = $pais_id;
        $p->estado_id = $estado_id;
        $p->ciudad_id = $ciudad_id;
        return $p;
    }

    /*
     * llena una persona natural
     */

    public function setPersonanatural($primer_nombre, $segundo_nombre, $sexo, $fecha_nacimiento, $libreta_militar, $edad, $rh, $primer_apellido, $segundo_apellido, $distrito_militar, $numero_pasaporte, $otra_nacionalidad, $clase_libreta, $fax, $padre, $madre, $ocupacion, $profesion, $nivel_estudio, $ultimo_grado, $religion_anterior, $ciudad_id, $estado_id, $pais_id, $persona_id, $estadocivil_id) {
        $p = new Personanatural();
        $p->primer_nombre = strtoupper($primer_nombre);
        $p->segundo_nombre = strtoupper($segundo_nombre);
        $p->sexo = $sexo;
        $p->fecha_nacimiento = $fecha_nacimiento;
        $p->libreta_militar = $libreta_militar;
        $p->edad = $edad;
        $p->rh = $rh;
        $p->primer_apellido = strtoupper($primer_apellido);
        $p->segundo_apellido = strtoupper($segundo_apellido);
        $p->distrito_militar = strtoupper($distrito_militar);
        $p->numero_pasaporte = $numero_pasaporte;
        $p->otra_nacionalidad = strtoupper($otra_nacionalidad);
        $p->clase_libreta = $clase_libreta;
        $p->fax = $fax;
        $p->padre = strtoupper($padre);
        $p->madre = strtoupper($madre);
        $p->ocupacion = strtoupper($ocupacion);
        $p->profesion = strtoupper($profesion);
        $p->nivel_estudio = $nivel_estudio;
        $p->ultimo_grado = $ultimo_grado;
        $p->religion_anterior = strtoupper($religion_anterior);
        $p->pais_id = $pais_id;
        $p->estado_id = $estado_id;
        $p->ciudad_id = $ciudad_id;
        $p->persona_id = $persona_id;
        $p->estadocivil_id = $estadocivil_id;
        return $p;
    }

    /*
     * llena un feligres
     */

    public function setFeligres($aceptado_por, $retiro_por, $pastor_oficiante, $estado_actual, $fecha_bautismo, $asociacion_origen, $distrito_origen, $iglesia_origen, $asociacion_destino, $distrito_destino, $iglesia_destino, $personanatural_id) {
        $f = new Feligres();
        $f->aceptado_por = $aceptado_por;
        $f->retiro_por = $retiro_por;
        $f->pastor_oficiante = strtoupper($pastor_oficiante);
        $f->estado_actual = $estado_actual;
        $f->fecha_bautismo = $fecha_bautismo;
        $f->asociacion_origen = $asociacion_origen;
        $f->distrito_origen = $distrito_origen;
        $f->iglesia_origen = $iglesia_origen;
        $f->asociacion_destino = $asociacion_destino;
        $f->distrito_destino = $distrito_destino;
        $f->iglesia_destino = $iglesia_destino;
        $f->iglesia_id = $iglesia_destino;
        $f->personanatural_id = $personanatural_id;
        return $f;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feligres  $feligres
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $feligres = Feligres::find($id);
        return view('feligresia.feligresia.feligres.show')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feligres  $feligres
     * @return \Illuminate\Http\Response
     */
    public function edit(Feligres $feligres) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feligres  $feligres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feligres $feligres) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feligres  $feligres
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $feligres = Feligres::find($id);
        $pn = $feligres->personanatural;
        if ($feligres->delete()) {
            $pn->persona->delete();
            $pn->delete();
            $this->setAuditoria($feligres->attributesToArray(), 'ELIMINAR', 'ELIMINACIÓN DE FELIGRÉS, DATOS ELIMINADOS: ');
            flash("La persona</strong> fue eliminada con exito.")->success();
            return redirect()->route('feligres.index');
        } else {
            flash("La persona</strong> no pudo ser eliminada.")->error();
            return redirect()->route('feligres.index');
        }
    }

}
