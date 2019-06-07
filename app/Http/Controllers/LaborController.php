<?php

namespace App\Http\Controllers;

use App\Labor;
use App\Categorialabor;
use App\Auditoriafeligresia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LaborRequest;
use Illuminate\Http\Request;

class LaborController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $labores = Labor::all();
        $labores->each(function($item) {
            $item->categorialabor;
        });
        return view('feligresia.feligresia.labores.list')
                        ->with('location', 'feligresia')
                        ->with('labores', $labores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categorias = Categorialabor::all()->pluck('nombre', 'id');
        return view('feligresia.feligresia.labores.create')
                        ->with('location', 'feligresia')
                        ->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LaborRequest $request) {
        $labor = new Labor($request->all());
        foreach ($labor->attributesToArray() as $key => $value) {
            $labor->$key = strtoupper($value);
        }
        $result = $labor->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE LABOR. DATOS: ";
            foreach ($labor->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La labor <strong>" . $labor->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('labor.index');
        } else {
            flash("La labor <strong>" . $labor->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('labor.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Labor  $labor
     * @return \Illuminate\Http\Response
     */
    public function show(Labor $labor) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Labor  $labor
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $labor = Labor::find($id);
        $categorias = Categorialabor::all()->pluck('nombre', 'id');
        return view('feligresia.feligresia.labores.edit')
                        ->with('location', 'feligresia')
                        ->with('labor', $labor)
                        ->with('categorias', $categorias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Labor  $labor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $labor = Labor::find($id);
        $m = new Labor($labor->attributesToArray());
        foreach ($labor->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $labor->$key = strtoupper($request->$key);
            }
        }
        $result = $labor->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LABOR. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($labor->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La labor <strong>" . $labor->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('labor.index');
        } else {
            flash("La labor <strong>" . $labor->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('labor.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Labor  $labor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $labor = Labor::find($id);
//        if (count($labor->ministerioextras) > 0) {
//            flash("El tipo de ministerio <strong>" . $labor->nombre . "</strong> no pudo ser eliminado porque tiene ministerios extras asociados.")->warning();
//            return redirect()->route('tipoministerio.index');
//        } else {
        $result = $labor->delete();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LABOR. DATOS ELIMINADOS: ";
            foreach ($labor->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La labor <strong>" . $labor->nombre . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('labor.index');
        } else {
            flash("La labor <strong>" . $labor->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('labor.index');
        }
//        }
    }

    /**
     * show all resource from a labor.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function feligreses($id) {
        $labor = Labor::find($id);
        if ($labor != null) {
            $felis = $labor->experiencialabors;
            if (count($felis) > 0) {
                $feligreses = null;
                foreach ($felis as $f) {
                    $o['id'] = $f->feligres_id;
                    $o['d'] = $f->feligres->personanatural->persona->tipodocumento->abreviatura . " - " . $f->feligres->personanatural->persona->numero_documento;
                    $o["f"] = $f->feligres->personanatural->primer_nombre . " " . $f->feligres->personanatural->segundo_nombre . " " . $f->feligres->personanatural->primer_apellido . " " . $f->feligres->personanatural->segundo_apellido;
                    $o['i'] = $f->feligres->iglesia->nombre;
                    $o['e'] = $f->feligres->estado_actual;
                    $o['t'] = $f->feligres->personanatural->persona->telefono . " - " . $f->feligres->personanatural->persona->celular;
                    $o['o'] = $f->feligres->personanatural->ocupacion;
                    $o['p'] = $f->feligres->personanatural->profesion;
                    $feligreses[] = $o;
                }
                return json_encode($feligreses);
            } else {
                return "null";
            }
        } else {
            return "null";
        }
    }

}
