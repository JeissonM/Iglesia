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
use App\Labor;
use App\Distrito;
use App\Pastor;
use App\Ciudad;
use App\Experiencialabor;
use App\Situacionfeligres;

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
        $situacion = Situacionfeligres::all()->pluck('nombre', 'id');
        return view('feligresia.feligresia.feligres.create')
                        ->with('location', 'feligresia')
                        ->with('asociaciones', $asociaciones)
                        ->with('estadosc', $estadosciviles)
                        ->with('paises', $paises)
                        ->with('tipodoc', $tiposdoc)
                        ->with('situacion', $situacion);
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
            $pn = $this->setPersonanatural($request->primer_nombre, $request->segundo_nombre, $request->sexo, $request->fecha_nacimiento, $request->libreta_militar, $request->edad, $request->rh, $request->primer_apellido, $request->segundo_apellido, $request->distrito_militar, $request->numero_pasaporte, $request->otra_nacionalidad, $request->clase_libreta, 'NO', $request->padre, $request->madre, $request->ocupacion, $request->profesion, $request->nivel_estudio, $request->ultimo_grado, $request->religion_anterior, $request->ciudad_id, $request->estado_id, $request->pais_id, $p->id, $request->estadocivil_id);
            if ($pn->save()) {
                $f = $this->setFeligres($request->aceptado_por, null, $request->pastor_oficiante, $request->estado_actual, $request->fecha_bautismo, $request->asociacion_origen, $request->distrito_origen, $request->iglesia_origen, $request->asociacion_destino, $request->distrito_destino, $request->iglesia_destino, $pn->id, $request->situacionfeligres_id);
                if ($f->save()) {
                    $this->setAuditoria($p->attributesToArray(), 'INSERTAR', 'CREACIÓN DE PERSONA, DATOS:');
                    $this->setAuditoria($pn->attributesToArray(), 'INSERTAR', 'CREACIÓN DE PERSONA NATURAL, DATOS:');
                    $this->setAuditoria($f->attributesToArray(), 'INSERTAR', 'CREACIÓN DE FELIGRÉS, DATOS:');
                    flash("La persona fue almacenada con exito.")->success();
                    return redirect()->route('feligres.index');
                } else {
                    $pn->delete();
                    $p->delete();
                    flash("La persona no pudo ser almacenada.")->error();
                    return redirect()->route('feligres.index');
                }
            } else {
                $p->delete();
                flash("La persona no pudo ser almacenada.")->error();
                return redirect()->route('feligres.index');
            }
        } else {
            flash("La persona no pudo ser almacenada.")->error();
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

    public function setFeligres($aceptado_por, $retiro_por, $pastor_oficiante, $estado_actual, $fecha_bautismo, $asociacion_origen, $distrito_origen, $iglesia_origen, $asociacion_destino, $distrito_destino, $iglesia_destino, $personanatural_id, $situacion) {
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
        $f->situacionfeligres_id = $situacion;
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
        $iglesiao = Iglesia::find($feligres->iglesia_origen);
        $iglesiad = Iglesia::find($feligres->iglesia_destino);
        return view('feligresia.feligresia.feligres.show')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres)
                        ->with('io', $iglesiao)
                        ->with('id', $iglesiad);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feligres  $feligres
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $feligres = Feligres::find($id);
        $iglesiao = Iglesia::find($feligres->iglesia_origen);
        $iglesiad = Iglesia::find($feligres->iglesia_destino);
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $estadosciviles = Estadocivil::all()->pluck('descripcion', 'id');
        $tiposdoc = Tipodocumento::all()->pluck('descripcion', 'id');
        $situacion = Situacionfeligres::all()->pluck('nombre', 'id');
        $rh = ['A+' => 'A +', 'A-' => 'A -', 'O+' => 'O +', 'O-' => 'O -',
            'B-' => 'B -', 'B+' => 'B +', 'AB+' => 'AB +', 'AB-' => 'AB -'];
        $nivel = ['PRIMARIA' => 'PRIMARIA', 'SECUNDARIA' => 'SECUNDARIA', 'BACHILLERATO' => 'BACHILLERATO',
            'TECNICO' => 'TÉCNICO', 'TECNOLOGO' => 'TECNÓLOGO', 'PROFESIONAL' => 'PROFESIONAL',
            'ESPECIALISTA' => 'ESPECIALISTA', 'MAGISTER' => 'MAGISTER', 'DOCTOR' => 'DOCTOR', 'OTRO' => 'OTRO'];
        $estadom = ['ACTIVO' => 'ACTIVO', 'INACTIVO' => 'INACTIVO'];
        return view('feligresia.feligresia.feligres.edit')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres)
                        ->with('iglesiao', $iglesiao)
                        ->with('iglesiad', $iglesiad)
                        ->with('asociaciones', $asociaciones)
                        ->with('estadosc', $estadosciviles)
                        ->with('paises', $paises)
                        ->with('tipodoc', $tiposdoc)
                        ->with('rh', $rh)
                        ->with('estadom', $estadom)
                        ->with('nivel', $nivel)
                        ->with('situacion', $situacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feligres  $feligres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $feligres = Feligres::find($id);
        $pn = $feligres->personanatural;
        $p = $pn->persona;
        $fu = $this->updateFeligres($request, $feligres);
        $pnu = $this->updatePersonaNatural($request, $pn);
        $pu = $this->updatePersona($request, $p);
        if ($fu->save()) {
            if ($pnu->save()) {
                if ($pu->save()) {
                    $this->setAuditoria($pu->attributesToArray(), 'ACTUALIZAR', 'ACTUALIZACIÓN DE PERSONA, DATOS:');
                    $this->setAuditoria($pnu->attributesToArray(), 'ACTUALIZAR', 'ACTUALIZACIÓN DE PERSONA NATURAL, DATOS:');
                    $this->setAuditoria($fu->attributesToArray(), 'ACTUALIZAR', 'ACTUALIZACIÓN DE FELIGRÉS, DATOS:');
                    flash("La persona fue modificada con exito.")->success();
                    return redirect()->route('feligres.index');
                } else {
                    $this->setAuditoria($pnu->attributesToArray(), 'ACTUALIZAR', 'ACTUALIZACIÓN DE PERSONA NATURAL, DATOS:');
                    $this->setAuditoria($fu->attributesToArray(), 'ACTUALIZAR', 'ACTUALIZACIÓN DE FELIGRÉS, DATOS:');
                    flash("El feligrés fue modificado pero los datos de persona general no pudo ser modificado.")->error();
                    return redirect()->route('feligres.index');
                }
            } else {
                $this->setAuditoria($fu->attributesToArray(), 'ACTUALIZAR', 'ACTUALIZACIÓN DE FELIGRÉS, DATOS:');
                flash("El feligrés fue modificado pero los datos de persona natural no pudo ser modificado.")->error();
                return redirect()->route('feligres.index');
            }
        } else {
            flash("La persona no pudo ser modificada.")->error();
            return redirect()->route('feligres.index');
        }
    }

    /*
     * edicion
     */

    public function updateFeligres($request, $f) {
        $f->aceptado_por = (isset($request->aceptado_por)) ? $request->aceptado_por : $f->aceptado_por;
        $f->retiro_por = (isset($request->retiro_por)) ? $request->retiro_por : $f->retiro_por;
        $f->pastor_oficiante = (isset($request->pastor_oficiante)) ? $request->pastor_oficiante : $f->pastor_oficiante;
        $f->estado_actual = (isset($request->estado_actual)) ? $request->estado_actual : $f->estado_actual;
        $f->fecha_bautismo = (isset($request->fecha_bautismo)) ? $request->fecha_bautismo : $f->fecha_bautismo;
        $f->asociacion_origen = (isset($request->asociacion_origen)) ? $request->asociacion_origen : $f->asociacion_origen;
        $f->distrito_origen = (isset($request->distrito_origen)) ? $request->distrito_origen : $f->distrito_origen;
        $f->iglesia_origen = (isset($request->iglesia_origen)) ? $request->iglesia_origen : $f->iglesia_origen;
        $f->asociacion_destino = (isset($request->asociacion_destino)) ? $request->asociacion_destino : $f->asociacion_destino;
        $f->distrito_destino = (isset($request->distrito_destino)) ? $request->distrito_destino : $f->distrito_destino;
        $f->iglesia_destino = (isset($request->iglesia_destino)) ? $request->iglesia_destino : $f->iglesia_destino;
        $f->iglesia_id = (isset($request->iglesia_id)) ? $request->iglesia_id : $f->iglesia_id;
        $f->situacionfeligres_id = (isset($request->situacionfeligres_id)) ? $request->situacionfeligres_id : $f->situacionfeligres_id;
        return $f;
    }

    public function updatePersonaNatural($request, $p) {
        $p->primer_nombre = (isset($request->primer_nombre)) ? $request->primer_nombre : $p->primer_nombre;
        $p->segundo_nombre = (isset($request->segundo_nombre)) ? $request->segundo_nombre : $p->segundo_nombre;
        $p->sexo = (isset($request->sexo)) ? $request->sexo : $p->sexo;
        $p->fecha_nacimiento = (isset($request->fecha_nacimiento)) ? $request->fecha_nacimiento : $p->fecha_nacimiento;
        $p->libreta_militar = (isset($request->libreta_militar)) ? $request->libreta_militar : $p->libreta_militar;
        $p->edad = (isset($request->edad)) ? $request->edad : $p->edad;
        $p->rh = (isset($request->rh)) ? $request->rh : $p->rh;
        $p->primer_apellido = (isset($request->primer_apellido)) ? $request->primer_apellido : $p->primer_apellido;
        $p->segundo_apellido = (isset($request->segundo_apellido)) ? $request->segundo_apellido : $p->segundo_apellido;
        $p->distrito_militar = (isset($request->distrito_militar)) ? $request->distrito_militar : $p->distrito_militar;
        $p->numero_pasaporte = (isset($request->numero_pasaporte)) ? $request->numero_pasaporte : $p->numero_pasaporte;
        $p->otra_nacionalidad = (isset($request->otra_nacionalidad)) ? $request->otra_nacionalidad : $p->otra_nacionalidad;
        $p->clase_libreta = (isset($request->clase_libreta)) ? $request->clase_libreta : $p->clase_libreta;
        $p->fax = (isset($request->fax)) ? $request->fax : $p->fax;
        $p->padre = (isset($request->padre)) ? $request->padre : $p->padre;
        $p->madre = (isset($request->madre)) ? $request->madre : $p->madre;
        $p->ocupacion = (isset($request->ocupacion)) ? $request->ocupacion : $p->ocupacion;
        $p->profesion = (isset($request->profesion)) ? $request->profesion : $p->profesion;
        $p->nivel_estudio = (isset($request->nivel_estudio)) ? $request->nivel_estudio : $p->nivel_estudio;
        $p->ultimo_grado = (isset($request->ultimo_grado)) ? $request->ultimo_grado : $p->ultimo_grado;
        $p->religion_anterior = (isset($request->religion_anterior)) ? $request->religion_anterior : $p->religion_anterior;
        $p->pais_id = (isset($request->pais_id)) ? $request->pais_id : $p->pais_id;
        $p->estado_id = (isset($request->estado_id)) ? $request->estado_id : $p->estado_id;
        $p->ciudad_id = (isset($request->ciudad_id)) ? $request->ciudad_id : $p->ciudad_id;
        $p->estadocivil_id = (isset($request->estadocivil_id)) ? $request->estadocivil_id : $p->estadocivil_id;
        return $p;
    }

    public function updatePersona($request, $p) {
        $p->tipopersona = (isset($request->tipopersona)) ? $request->tipopersona : $p->tipopersona;
        $p->direccion = (isset($request->direccion)) ? $request->direccion : $p->direccion;
        $p->mail = (isset($request->mail)) ? $request->mail : $p->mail;
        $p->celular = (isset($request->celular)) ? $request->celular : $p->celular;
        $p->telefono = (isset($request->telefono)) ? $request->telefono : $p->telefono;
        $p->numero_documento = (isset($request->numero_documento)) ? $request->numero_documento : $p->numero_documento;
        $p->lugar_expedicion = (isset($request->lugar_expedicion)) ? $request->lugar_expedicion : $p->lugar_expedicion;
        $p->fecha_expedicion = (isset($request->fecha_expedicion)) ? $request->fecha_expedicion : $p->fecha_expedicion;
        $p->nombrecomercial = (isset($request->nombrecomercial)) ? $request->nombrecomercial : $p->nombrecomercial;
        $p->regimen = (isset($request->regimen)) ? $request->regimen : $p->regimen;
        $p->tipodocumento_id = (isset($request->tipodocumento_id)) ? $request->tipodocumento_id : $p->tipodocumento_id;
        $p->pais_id = (isset($request->paisr_id)) ? $request->paisr_id : $p->pais_id;
        $p->estado_id = (isset($request->estador_id)) ? $request->estador_id : $p->estado_id;
        $p->ciudad_id = (isset($request->ciudadr_id)) ? $request->ciudadr_id : $p->ciudad_id;
        return $p;
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

    public function directoriofeligres() {
        $feligreses = Feligres::all();
        $iglesias = Iglesia::all()->pluck('nombre', 'id');
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $distritos = Distrito::all()->pluck('nombre', 'id');
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        $labor = Labor::all()->pluck('nombre', 'id');
        return view('comunicaciones.directorio_feligres.list')
                        ->with('location', 'comunicaciones')
                        ->with('feligreses', $feligreses)
                        ->with('iglesias', $iglesias)
                        ->with('distritos', $distritos)
                        ->with('labor', $labor)
                        ->with('asociaciones', $asociaciones)
                        ->with('ciudades', $ciudades);
    }

    public function ver($id) {
        $feligres = Feligres::find($id);
        $experiencia = $feligres->experiencialabors;
        $conocimientos = $feligres->conocimientos;
        return view('comunicaciones.directorio_feligres.show')
                        ->with('location', 'comunicaciones')
                        ->with('f', $feligres)
                        ->with('experiencia', $experiencia)
                        ->with('conocimientos', $conocimientos);
    }

    /**
     * show all resource from a distrito,ciudad,asociacion,iglesia u labor.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function feligres($id, $tipo) {
        if ($tipo == 'DISTRITO') {
            $distrito = Distrito::find($id);
            $iglesias = $distrito->iglesias;
            if (count($iglesias) > 0) {
                $feligreses = null;
                foreach ($iglesias as $igl) {
                    $feligres = $igl->feligres;
                    if (count($feligres) > 0) {
                        foreach ($feligres as $f) {
                            $obj["id"] = $f->id;
                            $obj["documento"] = $f->personanatural->persona->tipodocumento->abreviatura . " - " . $f->personanatural->persona->numero_documento;
                            $obj["nombre"] = $f->personanatural->primer_apellido . " " . $f->personanatural->segundo_apellido . " " . $f->personanatural->primer_nombre . " " . $f->personanatural->segundo_nombre;
                            $obj["iglesia"] = $f->iglesia->nombre;
                            $obj["estado"] = $f->estado_actual;
                            $obj["situacion"] = $f->situacionfeligres->nombre;
                            $obj["ocupacion"] = $f->ocupacion;
                            $obj["profesion"] = $f->profesion;
                            $feligreses[] = $obj;
                        }
                    }
                }
                return json_encode($feligreses);
            } else {
                return "null";
            }
        }
        if ($tipo == 'LABOR') {
            $experiencia = Experiencialabor::where('labor_id', $id)->get();
            if (count($experiencia) > 0) {
                $feligreses = null;
                foreach ($experiencia as $exp) {
                    $f = $exp->feligres;
                    $obj["id"] = $f->id;
                    $obj["documento"] = $f->personanatural->persona->tipodocumento->abreviatura . " - " . $f->personanatural->persona->numero_documento;
                    $obj["nombre"] = $f->personanatural->primer_apellido . " " . $f->personanatural->segundo_apellido . " " . $f->personanatural->primer_nombre . " " . $f->personanatural->segundo_nombre;
                    $obj["iglesia"] = $f->iglesia->nombre;
                    $obj["estado"] = $f->estado_actual;
                    $obj["situacion"] = $f->situacionfeligres->nombre;
                    $obj["ocupacion"] = $f->ocupacion;
                    $obj["profesion"] = $f->profesion;
                    $feligreses[] = $obj;
                }
                return json_encode($feligreses);
            } else {
                return "null";
            }
        }
        if ($tipo == 'ASOCIACION') {
            $asociacion = Asociacion::find($id);
            $dis = $asociacion->distritos;
            if (count($dis) > 0) {
                $feligreses = null;
                foreach ($dis as $d) {
                    $iglesias = $d->iglesias;
                    if (count($iglesias) > 0) {
                        foreach ($iglesias as $igl) {
                            $feligres = $igl->feligres;
                            if (count($feligres) > 0) {
                                foreach ($feligres as $f) {
                                    $obj["id"] = $f->id;
                                    $obj["documento"] = $f->personanatural->persona->tipodocumento->abreviatura . " - " . $f->personanatural->persona->numero_documento;
                                    $obj["nombre"] = $f->personanatural->primer_apellido . " " . $f->personanatural->segundo_apellido . " " . $f->personanatural->primer_nombre . " " . $f->personanatural->segundo_nombre;
                                    $obj["iglesia"] = $f->iglesia->nombre;
                                    $obj["estado"] = $f->estado_actual;
                                    $obj["situacion"] = $f->situacionfeligres->nombre;
                                    $obj["ocupacion"] = $f->ocupacion;
                                    $obj["profesion"] = $f->profesion;
                                    $feligreses[] = $obj;
                                }
                            }
                        }
                    }
                }
                return json_encode($feligreses);
            } else {
                return "null";
            }
        }
        if ($tipo == 'CIUDAD') {
            $ciudad = Ciudad::find($id);
            $iglesias = $ciudad->iglesias;
            if (count($iglesias) > 0) {
                $feligreses = null;
                foreach ($iglesias as $igl) {
                    $feligres = $igl->feligres;
                    if (count($feligres) > 0) {
                        foreach ($feligres as $f) {
                            $obj["id"] = $f->id;
                            $obj["documento"] = $f->personanatural->persona->tipodocumento->abreviatura . " - " . $f->personanatural->persona->numero_documento;
                            $obj["nombre"] = $f->personanatural->primer_apellido . " " . $f->personanatural->segundo_apellido . " " . $f->personanatural->primer_nombre . " " . $f->personanatural->segundo_nombre;
                            $obj["iglesia"] = $f->iglesia->nombre;
                            $obj["estado"] = $f->estado_actual;
                            $obj["situacion"] = $f->situacionfeligres->nombre;
                            $obj["ocupacion"] = $f->ocupacion;
                            $obj["profesion"] = $f->profesion;
                            $feligreses[] = $obj;
                        }
                    }
                }
                return json_encode($feligreses);
            } else {
                return "null";
            }
        }
        if ($tipo == 'IGLESIA') {
            $iglesias = Iglesia::find($id);
            $feligres = $iglesias->feligres;
            if (count($feligres) > 0) {
                $feligreses = null;
                foreach ($feligres as $f) {
                    $obj["id"] = $f->id;
                    $obj["documento"] = $f->personanatural->persona->tipodocumento->abreviatura . " - " . $f->personanatural->persona->numero_documento;
                    $obj["nombre"] = $f->personanatural->primer_apellido . " " . $f->personanatural->segundo_apellido . " " . $f->personanatural->primer_nombre . " " . $f->personanatural->segundo_nombre;
                    $obj["iglesia"] = $f->iglesia->nombre;
                    $obj["estado"] = $f->estado_actual;
                    $obj["situacion"] = $f->situacionfeligres->nombre;
                    $obj["ocupacion"] = $f->ocupacion;
                    $obj["profesion"] = $f->profesion;
                    $feligreses[] = $obj;
                }
                return json_encode($feligreses);
            } else {
                return "null";
            }
        }
    }

}
