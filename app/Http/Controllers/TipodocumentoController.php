<?php

namespace App\Http\Controllers;

use App\Tipodocumento;
use App\Auditoriafeligresia;
use App\Http\Requests\TipodocumentoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TipodocumentoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tipos = Tipodocumento::all();
        return view('feligresia.feligresia.tipodoc.list')
                        ->with('location', 'feligresia')
                        ->with('tipos', $tipos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.feligresia.tipodoc.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipodocumentoRequest $request) {
        $tipo = new Tipodocumento($request->all());
        foreach ($tipo->attributesToArray() as $key => $value) {
            $tipo->$key = strtoupper($value);
        }
        $result = $tipo->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE TIPO DE DOCUMENTO. DATOS: ";
            foreach ($tipo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El tipo de documento <strong>" . $tipo->descripcion . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('tipodoc.index');
        } else {
            flash("El tipo de documento <strong>" . $tipo->descripcion . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('tipodoc.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tipodocumento  $tipodocumento
     * @return \Illuminate\Http\Response
     */
    public function show(Tipodocumento $tipodocumento) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tipodocumento  $tipodocumento
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $tipo = Tipodocumento::find($id);
        return view('feligresia.feligresia.tipodoc.edit')
                        ->with('location', 'feligresia')
                        ->with('tipo', $tipo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tipodocumento  $tipodocumento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $tipo = Tipodocumento::find($id);
        $m = new Tipodocumento($tipo->attributesToArray());
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
            $str = "EDICION DE TIPO DE DOCUMENTO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($tipo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El tipo de documento <strong>" . $tipo->descripcion . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('tipodoc.index');
        } else {
            flash("El tipo de documento <strong>" . $tipo->descripcion . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('tipodoc.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tipodocumento  $tipodocumento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $tipo = Tipodocumento::find($id);
        if (count($tipo->personas) > 0) {
            flash("El tipo de documento <strong>" . $tipo->descripcion . "</strong> no pudo ser eliminado porque tiene personas asociadss.")->warning();
            return redirect()->route('tipodoc.index');
        } else {
            $result = $tipo->delete();
            if ($result) {
                $u = Auth::user();
                $aud = new Auditoriafeligresia();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE TIPO DE DOCUMENTO. DATOS: ";
                foreach ($tipo->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El tipo de documento <strong>" . $tipo->descripcion . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('tipodoc.index');
            } else {
                flash("El tipo de documento <strong>" . $tipo->descripcion . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('tipodoc.index');
            }
        }
    }

}
