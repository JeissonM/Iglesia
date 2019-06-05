<?php

namespace App\Http\Controllers;

use App\Ministerioextra;
use Illuminate\Http\Request;
use App\Http\Requests\MinisterioextraRequest;
use App\Tipoministerio;
use App\Auditoriafeligresia;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use App\Ministerionooficialmiembros;

class MinisterioextraController extends Controller {

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
                    $ministerios = Ministerionooficialmiembros::where('feligres_id', $feligres->id)->get();
                    return view('feligresia.ministerios.ministerioextra.list')
                                    ->with('location', 'feligresia')
                                    ->with('ministerios', $ministerios);
                } else {
                    flash('Usted no tiene permisos para ingresar a esta función.')->warning();
                    return redirect()->route('admin.feligresia');
                }
            } else {
                flash('Usted no tiene permisos para ingresar a esta función.')->warning();
                return redirect()->route('admin.feligresia');
            }
        } else {
            flash('Usted no tiene permisos para ingresar a esta función.')->warning();
            return redirect()->route('admin.feligresia');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p != null) {
            $pn = Personanatural::where('persona_id', $p->id)->first();
            if ($pn != null) {
                $feligres = Feligres::where('personanatural_id', $pn->id)->first();
                if ($feligres != null) {
                    $tipos = Tipoministerio::all()->pluck('nombre', 'id');
                    return view('feligresia.ministerios.ministerioextra.create')
                                    ->with('location', 'feligresia')
                                    ->with('tipos', $tipos)
                                    ->with('f', $feligres);
                } else {
                    flash('Usted no tiene permisos para ingresar a esta función.')->warning();
                    return redirect()->route('admin.feligresia');
                }
            } else {
                flash('Usted no tiene permisos para ingresar a esta función.')->warning();
                return redirect()->route('admin.feligresia');
            }
        } else {
            flash('Usted no tiene permisos para ingresar a esta función.')->warning();
            return redirect()->route('admin.feligresia');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MinisterioextraRequest $request) {
        $ministerio = new Ministerioextra($request->all());
        foreach ($ministerio->attributesToArray() as $key => $value) {
            if ($key != 'presentacion') {
                $ministerio->$key = strtoupper($value);
            }
        }
        $result = $ministerio->save();
        if ($result) {
            $u = Auth::user();
            $item = new Ministerionooficialmiembros();
            $item->feligres_id = $request->feligres_id;
            $item->funcion = "AUTOR";
            $item->ministerioextra_id = $ministerio->id;
            $item->save();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE MINISTERIO EXTRA-OFICIAL. DATOS: ";
            foreach ($ministerio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El ministerio <strong>" . $ministerio->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('ministerioextra.index');
        } else {
            flash("El ministerio <strong>" . $ministerio->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('ministerioextra.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ministerioextra  $ministerioextra
     * @return \Illuminate\Http\Response
     */
    public function show(Ministerioextra $ministerioextra) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ministerioextra  $ministerioextra
     * @return \Illuminate\Http\Response
     */
    public function edit(Ministerioextra $ministerioextra) {
        $tipos = Tipoministerio::all()->pluck('nombre', 'id');
        return view('feligresia.ministerios.ministerioextra.edit')
                        ->with('location', 'feligresia')
                        ->with('ministerio', $ministerioextra)
                        ->with('tipos', $tipos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ministerioextra  $ministerioextra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ministerioextra $ministerioextra) {
        $m = new Ministerioextra($ministerioextra->attributesToArray());
        foreach ($ministerioextra->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key != 'presentacion') {
                    $ministerioextra->$key = strtoupper($request->$key);
                } else {
                    $ministerioextra->$key = $request->$key;
                }
            }
        }
        $result = $ministerioextra->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE MINISTERIO EXTRA OFICIAL. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($ministerioextra->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El ministerio <strong>" . $ministerioextra->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('ministerioextra.index');
        } else {
            flash("El ministerio <strong>" . $ministerioextra->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('ministerioextra.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ministerioextra  $ministerioextra
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $ministerioextra = Ministerioextra::find($id);
//        if (count($estado->ciudades) > 0) {
//            flash("El Departamento <strong>" . $estado->nombre . "</strong> no pudo ser eliminado porque tiene ciudades/municipios asociados.")->warning();
//            return redirect()->route('estado.index');
//        } else {
        $result = $ministerioextra->delete();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE MINISTERIO EXTRA. DATOS: ";
            foreach ($ministerioextra->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El ministerio <strong>" . $ministerioextra->nombre . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('ministerioextra.index');
        } else {
            flash("El ministerio <strong>" . $ministerioextra->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('ministerioextra.index');
        }
//        }
    }

    public function miembros($id) {
        $m = Ministerioextra::find($id);
        $m->ministerionooficialmiembros;
        return view('feligresia.ministerios.ministerioextra.miembros')
                        ->with('location', 'feligresia')
                        ->with('m', $m);
    }

    public function miembroscrear(Request $request) {
        $miembro = new Ministerionooficialmiembros($request->all());
        foreach ($miembro->attributesToArray() as $key => $value) {
            $miembro->$key = strtoupper($value);
        }
        $p = Persona::where('numero_documento', $request->feligres)->first();
        if ($p != null) {
            $pn = Personanatural::where('persona_id', $p->id)->first();
            if ($pn != null) {
                $feligres = Feligres::where('personanatural_id', $pn->id)->first();
                if ($feligres != null) {
                    $miembro->feligres_id = $feligres->id;
                    $result = $miembro->save();
                    if ($result) {
                        $u = Auth::user();
                        $aud = new Auditoriafeligresia();
                        $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                        $aud->operacion = "INSERTAR";
                        $str = "CREACIÓN DE MIEMBRO DE MINISTERIO EXTRA-OFICIAL. DATOS: ";
                        foreach ($miembro->attributesToArray() as $key => $value) {
                            $str = $str . ", " . $key . ": " . $value;
                        }
                        $aud->detalles = $str;
                        $aud->save();
                        flash("El miembro fue almacenado de forma exitosa!")->success();
                        return redirect()->route('ministerioextra.miembros', $request->ministerioextra_id);
                    } else {
                        flash("El miembro no pudo ser almacenado. Error: " . $result)->error();
                        return redirect()->route('ministerioextra.miembros', $request->ministerioextra_id);
                    }
                } else {
                    flash('La identificación indicada no es un feligrés.')->warning();
                    return redirect()->route('ministerioextra.miembros', $request->ministerioextra_id);
                }
            } else {
                flash('La identificación indicada no es un feligrés.')->warning();
                return redirect()->route('ministerioextra.miembros', $request->ministerioextra_id);
            }
        } else {
            flash('La identificación indicada no es un feligrés.')->warning();
            return redirect()->route('ministerioextra.miembros', $request->ministerioextra_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ministerioextra  $miembro
     * @return \Illuminate\Http\Response
     */
    public function destroy2($ministerio, $id) {
        $miembro = Ministerionooficialmiembros::find($id);
        $result = $miembro->delete();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE MIEMBRO DE MINISTERIO EXTRA. DATOS: ";
            foreach ($miembro->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El miembro fue eliminado de forma exitosa!")->success();
            return redirect()->route('ministerioextra.miembros', $ministerio);
        } else {
            flash("El miembro no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('ministerioextra.miembros', $ministerio);
        }
    }

}
