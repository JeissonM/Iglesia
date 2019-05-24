<?php

namespace App\Http\Controllers;

use App\Junta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use App\Periodo;
use App\Iglesia;
use App\Pastor;
use App\Auditoriafeligresia;
use App\Cargogeneral;
use App\Miembrojunta;
use App\Agendajunta;
use App\Agendajuntapunto;
use App\Reunionjunta;
use App\Actajunta;

class JuntaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p !== null) {
            $pn = Personanatural::where('persona_id', $p->id)->first();
            if ($pn !== null) {
                $f = Feligres::where([['personanatural_id', $pn->id], ['estado_actual', 'ACTIVO']])->first();
                if ($f !== null) {
                    $per = Periodo::all()->sortByDesc('id');
                    $periodos = null;
                    foreach ($per as $pe) {
                        $periodos[$pe->id] = $pe->etiqueta . " - " . $pe->fechainicio . " - " . $pe->fechafin;
                    }
                    return view('feligresia.ministerios.junta.list')
                                    ->with('location', 'feligresia')
                                    ->with('f', $f)
                                    ->with('periodos', $periodos);
                } else {
                    flash('No tiene permisos para acceder a esta función.')->warning();
                    return redirect()->route('admin.feligresia');
                }
            } else {
                flash('No tiene permisos para acceder a esta función.')->warning();
                return redirect()->route('admin.feligresia');
            }
        } else {
            flash('No tiene permisos para acceder a esta función.')->warning();
            return redirect()->route('admin.feligresia');
        }
    }

    /*
     * muestra menu de junta
     */

    public function continuar($feligres_id, $periodo_id) {
        $f = Feligres::find($feligres_id);
        $p = Periodo::find($periodo_id);
        $junta = Junta::where([['iglesia_id', $f->iglesia_id], ['periodo_id', $p->id], ['vigente', 'SI']])->first();
        return view('feligresia.ministerios.junta.continuar')
                        ->with('location', 'feligresia')
                        ->with('f', $f)
                        ->with('p', $p)
                        ->with('junta', $junta);
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
        $f = Feligres::find($request->feligres_id);
        $p = Periodo::find($request->periodo_id);
        $juntaold = Junta::where([['iglesia_id', $f->iglesia_id], ['vigente', 'SI']])->first();
        if ($juntaold !== null) {
            flash('Hay una junta vigente en otro período, haga el cierre de dicha junta para crear una nueva.')->warning();
            return redirect()->route('junta.index');
        }
        $iglesia = Iglesia::find($f->iglesia_id);
        $pastor = Pastor::where('distrito_id', $iglesia->distrito_id)->first();
        $j = new Junta();
        $j->etiqueta = strtoupper($request->etiqueta);
        $j->vigente = "SI";
        $j->iglesia_id = $f->iglesia_id;
        $j->pastor_id = $pastor->id;
        $j->periodo_id = $p->id;
        if ($j->save()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE JUNTA. DATOS: ";
            foreach ($j->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La junta fue almacenada de forma exitosa!")->success();
            return redirect()->route('junta.index');
        } else {
            flash("La junta no pudo ser almacenada.")->error();
            return redirect()->route('junta.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function show(Junta $junta) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function edit(Junta $junta) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Junta $junta) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $junta = Junta::find($id);
        if (count($junta->miembrojuntas) > 0) {
            flash("La junta no pudo ser eliminada, tiene miembros asociados.")->error();
            return redirect()->route('junta.index');
        }
        if ($junta->delete()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE JUNTA. DATOS: ";
            foreach ($junta->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La junta fue eliminada con exito.")->success();
            return redirect()->route('junta.index');
        } else {
            flash("La junta no pudo ser eliminada.")->error();
            return redirect()->route('junta.index');
        }
    }

    /*
     * permite gestionar los miembros de una junta
     */

    public function miembros($f, $p, $j) {
        $feligres = Feligres::find($f);
        $periodo = Periodo::find($p);
        $junta = Junta::find($j);
        $junta->miembrojuntas;
        return view('feligresia.ministerios.junta.miembros')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres)
                        ->with('p', $periodo)
                        ->with('j', $junta);
    }

    /*
     * permite crear los miembros de una junta
     */

    public function crearmiembro($f, $p, $j) {
        $feligres = Feligres::find($f);
        $periodo = Periodo::find($p);
        $junta = Junta::find($j);
        $cg = Cargogeneral::all();
        $cargos = null;
        foreach ($cg as $c) {
            $cargos[$c->id] = $c->nombre . " - " . $c->descripcion . " - MINISTERIO: " . $c->ministerio->nombre;
        }
        $feligreses = Feligres::where([['iglesia_id', $junta->iglesia_id], ['estado_actual', 'ACTIVO']])->get();
        return view('feligresia.ministerios.junta.crearmiembro')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres)
                        ->with('p', $periodo)
                        ->with('cargos', $cargos)
                        ->with('feligreses', $feligreses)
                        ->with('j', $junta);
    }

    /*
     * agrega un nuevo miembro a la junta
     */

    public function agregarmiembro(Request $request) {
        $m = new Miembrojunta($request->all());
        if ($m->save()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "INSERCIÓN DE MIEMBROS DE JUNTA. DATOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El miembro fue agregado a la junta con exito.")->success();
            return redirect()->route('junta.miembros', [$request->secretario_id, $request->periodo_id, $request->junta_id]);
        } else {
            flash("El miembro no pudo ser agregado a la junta.")->error();
            return redirect()->route('junta.miembros', [$request->secretario_id, $request->periodo_id, $request->junta_id]);
        }
    }

    /*
     * permite eliminar los miembros de una junta
     */

    public function eliminarmiembro($f, $p, $j, $m) {
        $m = Miembrojunta::find($m);
        if ($m->delete()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE MIEMBROS DE JUNTA. DATOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El miembro fue eliminado de la junta con exito.")->success();
            return redirect()->route('junta.miembros', [$f, $p, $j]);
        } else {
            flash("El miembro no pudo ser eliminado de la junta.")->error();
            return redirect()->route('junta.miembros', [$f, $p, $j]);
        }
    }

    /*
     * agenda junta index
     */

    public function agendajuntaindex($f, $p, $j) {
        $feligres = Feligres::find($f);
        $periodo = Periodo::find($p);
        $junta = Junta::find($j);
        $agendas = Agendajunta::where('junta_id', $junta->id)->get();
        return view('feligresia.ministerios.junta.agendajuntaindex')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres)
                        ->with('p', $periodo)
                        ->with('agendas', $agendas)
                        ->with('j', $junta);
    }

    /*
     * crear agenda junta
     */

    public function crearagendajunta(Request $request) {
        $a = new Agendajunta($request->all());
        $a->titulo = strtoupper($a->titulo);
        if ($a->save()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "INSERCIÓN DE AGENDA DE JUNTA. DATOS: ";
            foreach ($a->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La agenda fue agregada a la junta con exito.")->success();
            return redirect()->route('junta.agendajuntaindex', [$request->secretario_id, $request->periodo_id, $request->junta_id]);
        } else {
            flash("La agenda no pudo ser agregada a la junta.")->error();
            return redirect()->route('junta.agendajuntaindex', [$request->secretario_id, $request->periodo_id, $request->junta_id]);
        }
    }

    /*
     * permite eliminar los miembros de una junta
     */

    public function eliminaragendajunta($f, $p, $j, $a) {
        $a = Agendajunta::find($a);
        if ($a->delete()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE AGENDAS DE JUNTA. DATOS: ";
            foreach ($a->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La agenda fue eliminada de la junta con exito.")->success();
            return redirect()->route('junta.agendajuntaindex', [$f, $p, $j]);
        } else {
            flash("La agenda no pudo ser eliminada de la junta.")->error();
            return redirect()->route('junta.agendajuntaindex', [$f, $p, $j]);
        }
    }

    /*
     * puntos agenda junta index
     */

    public function puntosagendajuntaindex($f, $p, $j, $a) {
        $feligres = Feligres::find($f);
        $periodo = Periodo::find($p);
        $junta = Junta::find($j);
        $agenda = Agendajunta::find($a);
        $agenda->agendajuntapuntos;
        $junta->miembrojuntas;
        return view('feligresia.ministerios.junta.agendajuntapuntosindex')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres)
                        ->with('p', $periodo)
                        ->with('agenda', $agenda)
                        ->with('j', $junta);
    }

    /*
     * puntos agenda junta crear
     */

    public function puntosagendajuntacrear(Request $request) {
        $v = explode(";", $request->feligres_id);
        $c = Cargogeneral::find($v[1]);
        $a = new Agendajuntapunto();
        $a->ministerio = $c->nombre . " - " . $c->ministerio->nombre;
        $a->punto = strtoupper($request->punto);
        $a->feligres_id = $v[0];
        $a->agendajunta_id = $request->agendajunta_id;
        if ($a->save()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "INSERCIÓN DE PUNTO DE AGENDA DE JUNTA. DATOS: ";
            foreach ($a->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El punto de agenda fue agregado con exito.")->success();
            return redirect()->route('junta.puntosagendajuntaindex', [$request->secretario_id, $request->periodo_id, $request->junta_id, $request->agendajunta_id]);
        } else {
            flash("El punto de agenda no pudo ser agregado.")->error();
            return redirect()->route('junta.puntosagendajuntaindex', [$request->secretario_id, $request->periodo_id, $request->junta_id, $request->agendajunta_id]);
        }
    }

    /*
     * puntos agenda junta eliminar punto
     */

    public function puntosagendajuntaeliminarpunto($f, $p, $j, $a, $pu) {
        $apu = Agendajuntapunto::find($pu);
        if ($apu->delete()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE PUNTOS DE AGENDAS DE JUNTA. DATOS: ";
            foreach ($apu->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El punto fue eliminado de la agenda con exito.")->success();
            return redirect()->route('junta.puntosagendajuntaindex', [$f, $p, $j, $a]);
        } else {
            flash("El punto no pudo ser eliminado de la agenda.")->error();
            return redirect()->route('junta.puntosagendajuntaindex', [$f, $p, $j, $a]);
        }
    }

    /*
     * reunion junta index
     */

    public function reunionjuntaindex($f, $p, $j) {
        $feligres = Feligres::find($f);
        $periodo = Periodo::find($p);
        $junta = Junta::find($j);
        $reuniones = Reunionjunta::where('junta_id', $j)->get();
        $agendas = Agendajunta::where('junta_id', $j)->get();
        return view('feligresia.ministerios.junta.reunionjuntaindex')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres)
                        ->with('p', $periodo)
                        ->with('j', $junta)
                        ->with('reuniones', $reuniones)
                        ->with('agendas', $agendas);
    }

    /*
     * reunion junta agregar
     */

    public function reunionjuntaagregar(Request $request) {
        $r = new Reunionjunta();
        $r->titulo = strtoupper($request->titulo);
        $r->fecha = $request->fecha;
        $r->asistentes = strtoupper($request->asistentes);
        $r->conclusiones = strtoupper($request->conclusiones);
        $r->junta_id = $request->junta_id;
        $r->agendajunta_id = $request->agendajunta_id;
        if ($r->save()) {
            $aj = new Actajunta();
            $aj->junta_id = $request->junta_id;
            if ($request->hasFile('acta')) {
                $file = $request->file("acta");
                $name = "ACTA_" . $r->id . "_" . $file->getClientOriginalName();
                $path = public_path() . "/docs/actas/";
                $file->move($path, $name);
                $aj->documento = $name;
            } else {
                $aj->documento = "NO";
            }
            $aj->save();
            $r->actajunta_id = $aj->id;
            $r->save();
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "INSERCIÓN DE REUNIÓN DE JUNTA. DATOS: ";
            foreach ($r->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La reunión fue agregada con exito.")->success();
            return redirect()->route('junta.reunionjuntaindex', [$request->secretario_id, $request->periodo_id, $request->junta_id]);
        } else {
            flash("La reunión no pudo ser agregada.")->error();
            return redirect()->route('junta.reunionjuntaindex', [$request->secretario_id, $request->periodo_id, $request->junta_id]);
        }
    }

    /*
     * junta reunion junta delete
     */

    public function reunionjuntadelete($f, $p, $j, $r) {
        $r = Reunionjunta::find($r);
        $path = $r->actajunta->documento;
        $r->actajunta->delete();
        if ($r->delete()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE REUNIONES DE JUNTA. DATOS: ";
            foreach ($r->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            unlink(public_path() . "/docs/actas/" . $path);
            flash("La reunión fue eliminada de la junta con exito.")->success();
            return redirect()->route('junta.reunionjuntaindex', [$f, $p, $j]);
        } else {
            flash("La reunión no pudo ser eliminada de la junta.")->error();
            return redirect()->route('junta.reunionjuntaindex', [$f, $p, $j]);
        }
    }

    /*
     * reunionjunta ver
     */

    public function reunionjuntaver($f, $p, $j, $r) {
        $feligres = Feligres::find($f);
        $periodo = Periodo::find($p);
        $junta = Junta::find($j);
        $reunion = Reunionjunta::find($r);
        $reunion->agendajunta;
        $reunion->actajunta;
        return view('feligresia.ministerios.junta.reunionjuntaver')
                        ->with('location', 'feligresia')
                        ->with('f', $feligres)
                        ->with('p', $periodo)
                        ->with('j', $junta)
                        ->with('r', $reunion);
    }

    public function cerrarJunta($id) {
        $junta = Junta::find($id);
        $junta->vigente = "NO";
        if ($junta->save()) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR";
            $str = "ACTUALIZAR SITUACIÓN DE JUNTA, CERRAR JUNTA. DATOS: ";
            foreach ($junta->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La junta fue cerrada con exito.")->success();
            return redirect()->route('junta.index');
        } else {
            flash("La junta no pudo ser cerrada.")->error();
            return redirect()->route('junta.index');
        }
    }

    public function getReunion($f, $p) {
        $fel = Feligres::find($f);
        $response['error'] = "NO";
        $junta = Junta::where([['iglesia_id', $fel->iglesia_id], ['periodo_id', $p]])->first();
        if ($junta !== null) {
            $reu = $junta->reunionjuntas;
            if (count($reu) > 0) {
                foreach ($reu as $r) {
                    $response['data'][$r->id] = $r->titulo . " (" . $r->fecha . ")";
                }
            }
        } else {
            $response['error'] = "SI";
        }
        return json_encode($response);
    }

}
