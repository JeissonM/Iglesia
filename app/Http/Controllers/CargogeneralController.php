<?php

namespace App\Http\Controllers;

use App\Cargogeneral;
use App\Auditoriafeligresia;
use App\Http\Requests\CargogeneralRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CargogeneralController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $cargos = Cargogeneral::all();
        return view('feligresia.ministerios.cargo_general.list')
                        ->with('location', 'feligresia')
                        ->with('cargos', $cargos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.ministerios.cargo_general.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CargogeneralRequest $request) {
        $cargo = new Cargogeneral($request->all());
        foreach ($cargo->attributesToArray() as $key => $value) {
            $cargo->$key = strtoupper($value);
        }
        $result = $cargo->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CARGO GENERAL. DATOS: ";
            foreach ($cargo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El cargo <strong>" . $cargo->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('cargogeneral.index');
        } else {
            flash("El cargo <strong>" . $cargo->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('cargogeneral.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cargogeneral  $cargogeneral
     * @return \Illuminate\Http\Response
     */
    public function show(Cargogeneral $cargogeneral) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cargogeneral  $cargogeneral
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $cargo = Cargogeneral::find($id);
        return view('feligresia.ministerios.cargo_general.edit')
                        ->with('location', 'feligresia')
                        ->with('cargo', $cargo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cargogeneral  $cargogeneral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $cargo = Cargogeneral::find($id);
        $m = new Cargogeneral($cargo->attributesToArray());
        foreach ($cargo->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $cargo->$key = strtoupper($request->$key);
            }
        }
        $result = $cargo->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE CARGO GENERAL. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($cargo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El cargo <strong>" . $cargo->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('cargogeneral.index');
        } else {
            flash("El tipo de ministerio <strong>" . $cargo->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('cargogeneral.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cargogeneral  $cargogeneral
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $cargo = Cargogeneral::find($id);
//        if (count($cargo->ministerioextras) > 0) {
//            flash("El tipo de ministerio <strong>" . $cargo->nombre . "</strong> no pudo ser eliminado porque tiene ministerios extras asociados.")->warning();
//            return redirect()->route('tipoministerio.index');
//        } else {
        $result = $cargo->delete();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE CARGO GENERAL. DATOS ELIMINADOS: ";
            foreach ($cargo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El cargo <strong>" . $cargo->nombre . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('tipoministerio.index');
        } else {
            flash("El cargo <strong>" . $cargo->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('tipoministerio.index');
        }
//        }
    }

}
