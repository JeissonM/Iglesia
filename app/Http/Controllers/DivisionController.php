<?php

namespace App\Http\Controllers;

use App\Division;
use Illuminate\Http\Request;
use App\Http\Requests\DivisionRequest;
use App\Ciudad;
use App\Auditoriafeligresia;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $divisiones = Division::all();
        $divisiones->each(function($item) {
            $item->ciudad;
        });
        return view('feligresia.estructura_eclesiastica.divisiones.list')
                        ->with('location', 'feligresia')
                        ->with('divisiones', $divisiones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.divisiones.create')
                        ->with('location', 'feligresia')
                        ->with('ciudades', $ciudades);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DivisionRequest $request) {
        $division = new Division($request->all());
        foreach ($division->attributesToArray() as $key => $value) {
            $division->$key = strtoupper($value);
        }
        $result = $division->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CONFERENCIA GENERAL. DATOS: ";
            foreach ($division->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La división <strong>" . $division->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('division.index');
        } else {
            flash("La división <strong>" . $division->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('division.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division) {
         return view('feligresia.estructura_eclesiastica.divisiones.show')
                        ->with('location', 'feligresia')
                        ->with('division', $division);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division) {
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.divisiones.edit')
                        ->with('location', 'feligresia')
                        ->with('division', $division)
                        ->with('ciudades', $ciudades);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Division $division) {
        $m = new Division($division->attributesToArray());
        foreach ($division->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $division->$key = strtoupper($request->$key);
            }
        }
        $result = $division->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE IASD. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($division->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La división <strong>" . $division->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('division.index');
        } else {
            flash("La división <strong>" . $division->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('division.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $division = Division::find($id);
        if (count($division->unions) > 0) {
            flash("La división <strong>" . $division->nombre . "</strong> no pudo ser eliminada porque tiene uniones asociadas.")->warning();
            return redirect()->route('division.index');
        } else {
            $result = $division->delete();
            if ($result) {
                $aud = new Auditoriafeligresia();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE IASD. DATOS ELIMINADOS: ";
                foreach ($division->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La división <strong>" . $division->nombre . "</strong> fue eliminada de forma exitosa!")->success();
                return redirect()->route('division.index');
            } else {
                flash("La división <strong>" . $division->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                return redirect()->route('division.index');
            }
        }
    }

}
