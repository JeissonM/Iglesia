<?php

namespace App\Http\Controllers;

use App\Periodo;
use Illuminate\Http\Request;
use App\Http\Requests\PeriodoRequest;
use App\Auditoriafeligresia;
use Illuminate\Support\Facades\Auth;

class PeriodoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $periodos = Periodo::all();
        return view('feligresia.estructura_eclesiastica.periodos.list')
                        ->with('location', 'feligresia')
                        ->with('periodos', $periodos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.estructura_eclesiastica.periodos.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $periodo = new Periodo($request->all());
        foreach ($periodo->attributesToArray() as $key => $value) {
            $periodo->$key = strtoupper($value);
        }
        $result = $periodo->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE PERÍODOS. DATOS: ";
            foreach ($periodo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El período <strong>" . $periodo->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('periodo.index');
        } else {
            flash("El período <strong>" . $periodo->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('periodo.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function show(Periodo $periodo) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function edit(Periodo $periodo) {
        return view('feligresia.estructura_eclesiastica.periodos.edit')
                        ->with('location', 'feligresia')
                        ->with('periodo', $periodo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Periodo $periodo) {
        $m = new Periodo($periodo->attributesToArray());
        foreach ($periodo->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $periodo->$key = strtoupper($request->$key);
            }
        }
        $result = $periodo->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE PERÍODO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($periodo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El período <strong>" . $periodo->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('periodo.index');
        } else {
            flash("El período <strong>" . $periodo->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('periodo.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $periodo = Periodo::find($id);
//        if (count($período->iglesias) > 0) {
//            flash("El período <strong>" . $período->nombre . "</strong> no pudo ser eliminado porque tiene iglesias asociadas.")->warning();
//            return redirect()->route('período.index');
//        } else {
        $result = $periodo->delete();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE PERÍODO. DATOS ELIMINADOS: ";
            foreach ($periodo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El período <strong>" . $periodo->nombre . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('periodo.index');
        } else {
            flash("El período <strong>" . $periodo->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('periodo.index');
        }
//        }
    }

}
