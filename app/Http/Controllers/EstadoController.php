<?php

namespace App\Http\Controllers;

use App\Estado;
use App\Pais;
use App\Auditoriafeligresia;
use App\Http\Requests\DepartamentoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EstadoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $dptos = Estado::all();
        $dptos->each(function ($dptos) {
            $dptos->pais;
        });
        return view('feligresia.datos_geograficos.departamentos.list')
                        ->with('location', 'feligresia')
                        ->with('dptos', $dptos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $paises = Pais::all()->pluck('nombre', 'id');
        return view('feligresia.datos_geograficos.departamentos.create')
                        ->with('location', 'feligresia')
                        ->with('paises', $paises);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartamentoRequest $request) {
        $estado = new Estado($request->all());
        foreach ($estado->attributesToArray() as $key => $value) {
            $estado->$key = strtoupper($value);
        }
        $result = $estado->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ESTADO. DATOS: ";
            foreach ($estado->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Departamento <strong>" . $estado->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('estado.index');
        } else {
            flash("El Departamento <strong>" . $estado->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('estado.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function show(Estado $estado) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $estado = Estado::find($id);
        $paises = Pais::all()->pluck('nombre', 'id');
        return view('feligresia.datos_geograficos.departamentos.edit')
                        ->with('location', 'feligresia')
                        ->with('estado', $estado)
                        ->with('paises', $paises);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $estado = Estado::find($id);
        $m = new Estado($estado->attributesToArray());
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
            $str = "EDICION DE ESTADO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($estado->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El Departamento <strong>" . $estado->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('estado.index');
        } else {
            flash("El Departamento <strong>" . $estado->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('estado.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $estado = Estado::find($id);
        if (count($estado->ciudades) > 0) {
            flash("El Departamento <strong>" . $estado->nombre . "</strong> no pudo ser eliminado porque tiene ciudades/municipios asociados.")->warning();
            return redirect()->route('estado.index');
        } else {
            $result = $estado->delete();
            if ($result) {
                $aud = new Auditoriafeligresia();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE ESTADO. DATOS ELIMINADOS: ";
                foreach ($estado->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El Departamento <strong>" . $estado->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('estado.index');
            } else {
                flash("El Departamento <strong>" . $estado->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('estado.index');
            }
        }
    }

    /**
     * show all resource from a estado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ciudades($id) {
        $estado = Estado::find($id);
        $ciudades = $estado->ciudades;
        if (count($ciudades) > 0) {
            $ciudadesf = null;
            foreach ($ciudades as $value) {
                $obj["id"] = $value->id;
                $obj["value"] = $value->nombre;
                $ciudadesf[] = $obj;
            }
            return json_encode($ciudadesf);
        } else {
            return "null";
        }
    }

}
