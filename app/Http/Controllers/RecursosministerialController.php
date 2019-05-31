<?php

namespace App\Http\Controllers;

use App\Recursosministerial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Periodo;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use App\Junta;
use App\Miembrojunta;
use App\Http\Requests\RecursoministerialRequest;
use App\Auditoriagestiondocumental;
use App\Recursosministerialitem;

class RecursosministerialController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $recursos = Recursosministerial::all();
        if (count($recursos) > 0) {
            $recursos->each(function($item) {
                $item->recursosministerialitems;
            });
        }
        $per = Periodo::all()->sortByDesc('id');
        $periodos = null;
        if (count($per) > 0) {
            foreach ($per as $p) {
                $periodos[$p->id] = $p->etiqueta . "  -  DESDE  " . $p->fechainicio . "  HASTA  " . $p->fechafin;
            }
        }
        return view('gestion_documental.recursos_ministeriales.list')
                        ->with('location', 'gestion-documental')
                        ->with('recursos', $recursos)
                        ->with('periodos', $periodos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $periodo = Periodo::find($id);
        if ($periodo != null) {
            $u = Auth::user();
            $p = Persona::where('numero_documento', $u->identificacion)->first();
            if ($p != null) {
                $pn = Personanatural::where('persona_id', $p->id)->first();
                if ($pn != null) {
                    $feligres = Feligres::where('personanatural_id', $pn->id)->first();
                    if ($feligres != null) {
                        $junta = Junta::where([['periodo_id', $periodo->id], ['iglesia_id', $feligres->iglesia_id], ['vigente', 'SI']])->first();
                        if ($junta != null) {
                            $cargos = Miembrojunta::where([['feligres_id', $feligres->id], ['junta_id', $junta->id]])->get();
                            if (count($cargos) > 0) {
                                $ministerios = null;
                                foreach ($cargos as $c) {
                                    $ministerios[$c->cargogeneral->ministerio_id] = $c->cargogeneral->ministerio->nombre;
                                    return view('gestion_documental.recursos_ministeriales.create')
                                                    ->with('location', 'gestion-documental')
                                                    ->with('ministerios', $ministerios)
                                                    ->with('u', $u)
                                                    ->with('p', $periodo);
                                }
                            } else {
                                flash('Usted no tiene ministerios a cargo en este período. También es posible que en el período indicado no hay una junta vigente.')->warning();
                                return redirect()->route('recursosministeriales.index');
                            }
                        } else {
                            flash('Usted no tiene ministerios a cargo en este período. También es posible que en el período indicado no hay una junta vigente.')->warning();
                            return redirect()->route('recursosministeriales.index');
                        }
                    } else {
                        flash('No tiene permisos para realizar éste proceso')->warning();
                        return redirect()->route('recursosministeriales.index');
                    }
                } else {
                    flash('No tiene permisos para realizar éste proceso')->warning();
                    return redirect()->route('recursosministeriales.index');
                }
            } else {
                flash('No tiene permisos para realizar éste proceso')->warning();
                return redirect()->route('recursosministeriales.index');
            }
        } else {
            flash('No hay período válido para realizar el proceso.')->warning();
            return redirect()->route('recursosministeriales.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecursoministerialRequest $request) {
        $r = new Recursosministerial($request->all());
        foreach ($r->attributesToArray() as $key => $value) {
            $r->$key = strtoupper($value);
        }
        if (!isset($request->recurso)) {
            flash("No hay recursos para almacenar")->error();
            return redirect()->route('recursosministeriales.index');
        }
        if ($r->save()) {
            $files = $request->recurso;
            foreach ($files as $f) {
                $hoy = getdate();
                $name = "Recurso_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . $f->getClientOriginalName();
                $path = public_path() . "/docs/recursos/";
                $f->move($path, $name);
                $ri = new Recursosministerialitem();
                $ri->recurso = $name;
                $ri->recursosministerial_id = $r->id;
                $ri->save();
            }
            $u = Auth::user();
            $aud = new Auditoriagestiondocumental();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE RECURSOS MINISTERIALES . DATOS: ";
            foreach ($r->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El/Los recurso(s) fue(fueron) almacenado(s) de forma exitosa!")->success();
            return redirect()->route('recursosministeriales.index');
        } else {
            flash("El/Los recurso(s) no pudo(pudieron) ser almacenado(s) de forma exitosa!")->error();
            return redirect()->route('recursosministeriales.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recursosministerial  $recursosministerial
     * @return \Illuminate\Http\Response
     */
    public function show(Recursosministerial $recursosministerial) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recursosministerial  $recursosministerial
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $r = Recursosministerial::find($id);
        $r->recursosministerialitems;
        return view('gestion_documental.recursos_ministeriales.edit')
                        ->with('location', 'gestion-documental')
                        ->with('r', $r);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recursosministerial  $recursosministerial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recursosministerial $recursosministerial) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recursosministerial  $recursosministerial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $r = Recursosministerial::find($id);
        $items = $r->recursosministerialitems;
        if (count($items) > 0) {
            foreach ($items as $i) {
                unlink(public_path() . "/docs/recursos/" . $i->recurso);
            }
        }
        $result = $r->delete();
        if ($result) {
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE RECURSOS, DATOS ELIMINADOS: ";
            foreach ($r->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El recurso fue eliminado!")->success();
            return redirect()->route('recursosministeriales.index');
        } else {
            flash("El recurso no pudo ser eliminado!")->error();
            return redirect()->route('recursosministeriales.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request) {
        $r = new Recursosministerialitem($request->all());
        if (!isset($request->recurso)) {
            flash("No hay recurso para almacenar")->error();
            return redirect()->route('recursosministeriales.edit', $request->recursosministerial_id);
        }
        if ($r->save()) {
            $file = $request->recurso;
            $hoy = getdate();
            $name = "Recurso_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . $file->getClientOriginalName();
            $path = public_path() . "/docs/recursos/";
            $file->move($path, $name);
            $r->recurso = $name;
            $r->save();
            flash("El recurso fue almacenado de forma exitosa!")->success();
            return redirect()->route('recursosministeriales.edit', $request->recursosministerial_id);
        } else {
            flash("El recurso no pudo ser almacenado de forma exitosa!")->error();
            return redirect()->route('recursosministeriales.edit', $request->recursosministerial_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recursosministerial  $recursosministerial
     * @return \Illuminate\Http\Response
     */
    public function destroy2($recurso, $item) {
        $r = Recursosministerialitem::find($item);
        $nombre = $r->recurso;
        $result = $r->delete();
        if ($result) {
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE RECURSOS, DATOS ELIMINADOS: ";
            foreach ($r->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            unlink(public_path() . "/docs/recursos/" . $nombre);
            flash("El recurso fue eliminado!")->success();
            return redirect()->route('recursosministeriales.edit', $recurso);
        } else {
            flash("El recurso no pudo ser eliminado!")->error();
            return redirect()->route('recursosministeriales.edit', $recurso);
        }
    }

}
