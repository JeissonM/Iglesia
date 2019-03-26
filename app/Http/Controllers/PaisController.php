<?php

namespace App\Http\Controllers;

use App\Pais;
use App\Auditoriafeligresia;
use App\Http\Requests\PaisRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaisController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $paises = pais::all();
        return view('feligresia.datos_geograficos.paises.list')
                        ->with('location', 'feligresia')
                        ->with('paises', $paises);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.datos_geograficos.paises.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaisRequest $request) {
        $pais = new Pais($request->all());
        foreach ($pais->attributesToArray() as $key => $value) {
            $pais->$key = strtoupper($value);
        }
        $result = $pais->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE PAIS. DATOS: ";
            foreach ($pais->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Pais <strong>" . $pais->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('pais.index');
        } else {
            flash("El Pais <strong>" . $pais->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('pais.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pais  $pais
     * @return \Illuminate\Http\Response
     */
    public function show(Pais $pais) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pais  $pais
     * @return \Illuminate\Http\Response
     */
    public function edit(Pais $pais) {
        dd($pais);
        return view('feligresia.datos_geograficos.paises.edit')
                        ->with('location', 'feligresia')
                        ->with('pais', $pais);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pais  $pais
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pais $pais) {
        //$pais = Pais::find($id);
        $m = new Pais($pais->attributesToArray());
        foreach ($pais->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $pais->$key = strtoupper($request->$key);
            }
        }
        $result = $pais->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE PAIS. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($pais->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Pais <strong>" . $pais->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('pais.index');
        } else {
            flash("El Pais <strong>" . $pais->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('pais.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pais  $pais
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pais $pais) {
        //$pais = Pais::find($id);
        if (count($pais->departamentos) > 0) {
            flash("El Pais <strong>" . $pais->nombre . "</strong> no pudo ser eliminado porque tiene estados/departamentos asociados.")->warning();
            return redirect()->route('pais.index');
        } else {
            $result = $pais->delete();
            if ($result) {
                $aud = new Auditoriafeligresia();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE PAIS. DATOS ELIMINADOS: ";
                foreach ($pais->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El Pais <strong>" . $pais->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('pais.index');
            } else {
                flash("El Pais <strong>" . $pais->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('pais.index');
            }
        }
    }

}
