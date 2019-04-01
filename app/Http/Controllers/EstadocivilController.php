<?php

namespace App\Http\Controllers;

use App\Estadocivil;
use App\Auditoriafeligresia;
use App\Http\Requests\EstadocivilRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EstadocivilController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $estados = Estadocivil::all();
        return view('feligresia.feligresia.estadocivil.list')
                        ->with('location', 'feligresia')
                        ->with('estados', $estados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.feligresia.estadocivil.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstadocivilRequest $request) {
        $estado = new Estadocivil($request->all());
        foreach ($estado->attributesToArray() as $key => $value) {
            $estado->$key = strtoupper($value);
        }
        $result = $estado->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ESTADO CIVIL. DATOS: ";
            foreach ($estado->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El estado civil <strong>" . $estado->descripcion . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('estadocivil.index');
        } else {
            flash("El estado civil <strong>" . $estado->descripcion . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('estadocivil.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estadocivil  $estadocivil
     * @return \Illuminate\Http\Response
     */
    public function show(Estadocivil $estadocivil) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Estadocivil  $estadocivil
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $estado = Estadocivil::find($id);
        return view('feligresia.feligresia.estadocivil.edit')
                        ->with('location', 'feligresia')
                        ->with('estado', $estado);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Estadocivil  $estadocivil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $estado = Estadocivil::find($id);
        $m = new Estadocivil($estado->attributesToArray());
        foreach ($estado->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $estado->$key = strtoupper($request->$key);
            }
        }
        $result = $estado->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE ESTADO CIVIL. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($estado->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El estado civil <strong>" . $estado->descripcion . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('estadocivil.index');
        } else {
            flash("El estado civil <strong>" . $estado->descripcion . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('estadocivil.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Estadocivil  $estadocivil
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $estado = Estadocivil::find($id);
        if (count($estado->personanaturals) > 0) {
            flash("El estado civil <strong>" . $estado->descripcion . "</strong> no pudo ser eliminado porque tiene personas asociadss.")->warning();
            return redirect()->route('estadocivil.index');
        } else {
            $result = $estado->delete();
            if ($result) {
                $u = Auth::user();
                $aud = new Auditoriafeligresia();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE ESTADO CIVIL. DATOS: ";
                foreach ($estado->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El estado civil <strong>" . $estado->descripcion . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('estadocivil.index');
            } else {
                flash("El estado civil <strong>" . $estado->descripcion . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('estadocivil.index');
            }
        }
    }

}
