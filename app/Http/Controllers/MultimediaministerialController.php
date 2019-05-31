<?php

namespace App\Http\Controllers;

use App\Multimediaministerial;
use Illuminate\Http\Request;
use App\Periodo;
use App\Ministerionooficialmiembros;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use Illuminate\Support\Facades\Auth;
use App\Ministerioextra;
use App\Http\Requests\MultimediaministerialRequest;
use App\Multimediaministerialitem;
use App\Auditoriagestiondocumental;

class MultimediaministerialController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = Personanatural::where('persona_id', $p->id)->first();
            if ($pn != null) {
                $feligres = Feligres::where('personanatural_id', $pn->id)->first();
                if ($feligres != null) {
                    $min = Ministerionooficialmiembros::where('feligres_id', $feligres->id)->get();
                    return view('gestion_documental.multimedia_ministerial.list')
                                    ->with('location', 'gestion-documental')
                                    ->with('min', $min);
                } else {
                    flash('Usted no es miembro de ministerios no oficiales')->warning();
                    return redirect()->route('admin.gestiondocumental');
                }
            } else {
                flash('Usted no es miembro de ministerios no oficiales')->warning();
                return redirect()->route('admin.gestiondocumental');
            }
        } else {
            flash('Usted no es miembro de ministerios no oficiales')->warning();
            return redirect()->route('admin.gestiondocumental');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $u = Auth::user();
        $m = Ministerioextra::find($id);
        return view('gestion_documental.multimedia_ministerial.create')
                        ->with('location', 'gestion-documental')
                        ->with('m', $m)
                        ->with('u', $u);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MultimediaministerialRequest $request) {
        $r = new Multimediaministerial($request->all());
        foreach ($r->attributesToArray() as $key => $value) {
            $r->$key = strtoupper($value);
        }
        if (!isset($request->recurso)) {
            flash("No hay recursos multimedia para almacenar")->error();
            return redirect()->route('multimediaministerial.lista', $request->ministerioextra_id);
        }
        if ($r->save()) {
            $files = $request->recurso;
            foreach ($files as $f) {
                $hoy = getdate();
                $name = "Multimedia_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . $f->getClientOriginalName();
                $path = public_path() . "/docs/multimedia/";
                $f->move($path, $name);
                $ri = new Multimediaministerialitem();
                $ri->recurso = $name;
                $ri->multimediaministerial_id = $r->id;
                $ri->save();
            }
            $u = Auth::user();
            $aud = new Auditoriagestiondocumental();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE RECURSOS MULTIMEDIA MINISTERIALES . DATOS: ";
            foreach ($r->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El/Los recurso(s) multimedia fue(fueron) almacenado(s) de forma exitosa!")->success();
            return redirect()->route('multimediaministerial.lista', $request->ministerioextra_id);
        } else {
            flash("El/Los recurso(s) multimedia no pudo(pudieron) ser almacenado(s) de forma exitosa!")->error();
            return redirect()->route('multimediaministerial.lista', $request->ministerioextra_id);
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
        $r = Multimediaministerial::find($id);
        $r->multimediaministerialitems;
        return view('gestion_documental.multimedia_ministerial.edit')
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
        $r = Multimediaministerial::find($id);
        $min = $r->ministerioextra_id;
        $items = $r->multimediaministerialitems;
        if (count($items) > 0) {
            foreach ($items as $i) {
                unlink(public_path() . "/docs/multimedia/" . $i->recurso);
            }
        }
        $result = $r->delete();
        if ($result) {
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE RECURSOS MuLTIMEDIA, DATOS ELIMINADOS: ";
            foreach ($r->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El recurso fue eliminado!")->success();
            return redirect()->route('multimediaministerial.lista', $min);
        } else {
            flash("El recurso no pudo ser eliminado!")->error();
            return redirect()->route('multimediaministerial.lista', $min);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request) {
        $r = new Multimediaministerialitem($request->all());
        if (!isset($request->recurso)) {
            flash("No hay recurso para almacenar")->error();
            return redirect()->route('multimediaministerial.edit', $request->multimediaministerial_id);
        }
        if ($r->save()) {
            $file = $request->recurso;
            $hoy = getdate();
            $name = "Recurso_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . $file->getClientOriginalName();
            $path = public_path() . "/docs/multimedia/";
            $file->move($path, $name);
            $r->recurso = $name;
            $r->save();
            flash("El recurso fue almacenado de forma exitosa!")->success();
            return redirect()->route('multimediaministerial.edit', $request->multimediaministerial_id);
        } else {
            flash("El recurso no pudo ser almacenado de forma exitosa!")->error();
            return redirect()->route('multimediaministerial.edit', $request->multimediaministerial_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recursosministerial  $recursosministerial
     * @return \Illuminate\Http\Response
     */
    public function destroy2($recurso, $item) {
        $r = Multimediaministerialitem::find($item);
        $nombre = $r->recurso;
        $result = $r->delete();
        if ($result) {
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE RECURSOS MULTIMEDIA, DATOS ELIMINADOS: ";
            foreach ($r->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            unlink(public_path() . "/docs/multimedia/" . $nombre);
            flash("El recurso fue eliminado!")->success();
            return redirect()->route('multimediaministerial.edit', $recurso);
        } else {
            flash("El recurso no pudo ser eliminado!")->error();
            return redirect()->route('multimediaministerial.edit', $recurso);
        }
    }

    public function lista($id) {
        $m = Ministerioextra::find($id);
        $m->multimediaministerials;
        return view('gestion_documental.multimedia_ministerial.multimedia')
                        ->with('location', 'gestion-documental')
                        ->with('m', $m);
    }

}
