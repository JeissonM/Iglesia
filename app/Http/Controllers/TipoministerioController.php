<?php

namespace App\Http\Controllers;

use App\Tipoministerio;
use App\Auditoriafeligresia;
use App\Http\Requests\TipoministerioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TipoministerioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tipos = Tipoministerio::all();
        return view('feligresia.ministerios.tipoministerio.list')
                        ->with('location', 'feligresia')
                        ->with('tipos', $tipos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.ministerios.tipoministerio.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoministerioRequest $request) {
        $tipo = new Tipoministerio($request->all());
        foreach ($tipo->attributesToArray() as $key => $value) {
            $tipo->$key = strtoupper($value);
        }
        $result = $tipo->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE TIPO DE MINISTERIO. DATOS: ";
            foreach ($tipo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El tipo de ministerio <strong>" . $tipo->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('tipoministerio.index');
        } else {
            flash("El tipo de ministerio <strong>" . $tipo->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('tipoministerio.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tipoministerio  $tipoministerio
     * @return \Illuminate\Http\Response
     */
    public function show(Tipoministerio $tipoministerio) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tipoministerio  $tipoministerio
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $tipo = Tipoministerio::find($id);
        return view('feligresia.ministerios.tipoministerio..edit')
                        ->with('location', 'feligresia')
                        ->with('tipo', $tipo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tipoministerio  $tipoministerio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $tipo = Tipoministerio::find($id);
        $m = new Tipoministerio($tipo->attributesToArray());
        foreach ($tipo->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $tipo->$key = strtoupper($request->$key);
            }
        }
        $result = $tipo->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE TIPO DE MINISTERIOS. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($tipo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El tipo de ministerio <strong>" . $tipo->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('tipoministerio.index');
        } else {
            flash("El tipo de ministerio <strong>" . $tipo->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('tipoministerio.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tipoministerio  $tipoministerio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $tipo = Tipoministerio::find($id);
        if (count($tipo->ministerioextras) > 0) {
            flash("El tipo de ministerio <strong>" . $tipo->nombre . "</strong> no pudo ser eliminado porque tiene ministerios extras asociados.")->warning();
            return redirect()->route('tipoministerio.index');
        } else {
            $result = $tipo->delete();
            if ($result) {
                $aud = new Auditoriafeligresia();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE TIPO DE MINISTERIO. DATOS ELIMINADOS: ";
                foreach ($tipo->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El tipo de ministerio <strong>" . $tipo->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('tipoministerio.index');
            } else {
                flash("El tipo de ministerio <strong>" . $tipo->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('tipoministerio.index');
            }
        }
    }

}
