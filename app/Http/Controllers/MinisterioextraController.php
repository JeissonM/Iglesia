<?php

namespace App\Http\Controllers;

use App\Ministerioextra;
use Illuminate\Http\Request;
use App\Http\Requests\MinisterioextraRequest;
use App\Tipoministerio;
use App\Auditoriafeligresia;
use Illuminate\Support\Facades\Auth;

class MinisterioextraController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $ministerios = Ministerioextra::all();
        return view('feligresia.ministerios.ministerioextra.list')
                        ->with('location', 'feligresia')
                        ->with('ministerios', $ministerios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $tipos = Tipoministerio::all()->pluck('nombre', 'id');
        return view('feligresia.ministerios.ministerioextra.create')
                        ->with('location', 'feligresia')
                        ->with('tipos', $tipos);
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
            $ministerio->$key = strtoupper($value);
        }
        $result = $ministerio->save();
        if ($result) {
            $u = Auth::user();
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
                $ministerioextra->$key = strtoupper($request->$key);
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

}
