<?php

namespace App\Http\Controllers;

use App\Ministerio;
use Illuminate\Http\Request;
use App\Http\Requests\MinisterioRequest;
use App\Auditoriafeligresia;
use Illuminate\Support\Facades\Auth;

class MinisterioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $ministerios = Ministerio::all();
        return view('feligresia.ministerios.ministerios.list')
                        ->with('location', 'feligresia')
                        ->with('ministerios', $ministerios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.ministerios.ministerios.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MinisterioRequest $request) {
        $ministerio = new Ministerio($request->all());
        foreach ($ministerio->attributesToArray() as $key => $value) {
            $ministerio->$key = strtoupper($value);
        }
        $result = $ministerio->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE MINISTERIO. DATOS: ";
            foreach ($ministerio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El ministerio <strong>" . $ministerio->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('ministerio.index');
        } else {
            flash("El ministerio <strong>" . $ministerio->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('ministerio.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ministerio  $ministerio
     * @return \Illuminate\Http\Response
     */
    public function show(Ministerio $ministerio) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ministerio  $ministerio
     * @return \Illuminate\Http\Response
     */
    public function edit(Ministerio $ministerio) {
        //$ministerio = Ministerio::find($id);
        return view('feligresia.ministerios.ministerios.edit')
                        ->with('location', 'feligresia')
                        ->with('ministerio', $ministerio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ministerio  $ministerio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ministerio $ministerio) {
        //$ministerio = Ministerio::find($id);
        $m = new Ministerio($ministerio->attributesToArray());
        foreach ($ministerio->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $ministerio->$key = strtoupper($request->$key);
            }
        }
        $result = $ministerio->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE MINISTERIO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($ministerio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El ministerio <strong>" . $ministerio->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('ministerio.index');
        } else {
            flash("El ministerio <strong>" . $ministerio->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('ministerio.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ministerio  $ministerio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $ministerio = Ministerio::find($id);
//        if (count($estado->ciudades) > 0) {
//            flash("El Departamento <strong>" . $estado->nombre . "</strong> no pudo ser eliminado porque tiene ciudades/municipios asociados.")->warning();
//            return redirect()->route('estado.index');
//        } else {
        $result = $ministerio->delete();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE MINISTERIO. DATOS: ";
            foreach ($ministerio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El ministerio <strong>" . $ministerio->nombre . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('ministerio.index');
        } else {
            flash("El ministerio <strong>" . $ministerio->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('ministerio.index');
        }
//        }
    }

}
