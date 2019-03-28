<?php

namespace App\Http\Controllers;

use App\Union;
use App\Ciudad;
use App\Division;
use App\Auditoriafeligresia;
use App\Http\Requests\UnionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UnionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $uniones = Union::all();
        $uniones->each(function($item) {
            $item->ciudad;
            $item->union;
        });
        return view('feligresia.estructura_eclesiastica.uniones.list')
                        ->with('location', 'feligresia')
                        ->with('uniones', $uniones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $divisiones = Division::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.uniones.create')
                        ->with('location', 'feligresia')
                        ->with('ciudades', $ciudades)
                        ->with('divisiones', $divisiones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnionRequest $request) {
        $union = new Union($request->all());
        foreach ($union->attributesToArray() as $key => $value) {
            if ($key == 'sitioweb') {
                $union->$key = $value;
            } else {
                $union->$key = strtoupper($value);
            }
        }
        $result = $union->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE UNIÓN. DATOS: ";
            foreach ($union->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $union->ciudad->nombre;
                } else if ($key == 'division_id') {
                    $str = $str . ", " . $key . ": " . $value . ", division:" . $union->division->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La unión <strong>" . $union->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('union.index');
        } else {
            flash("La unión <strong>" . $union->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('union.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Union  $union
     * @return \Illuminate\Http\Response
     */
    public function show(Union $union) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Union  $union
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $union = Union::find($id);
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $divisiones = Division::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.uniones.edit')
                        ->with('location', 'feligresia')
                        ->with('union', $union)
                        ->with('ciudades', $ciudades)
                        ->with('divisiones', $divisiones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Union  $union
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $union = Union::find($id);
        $m = new Union($union->attributesToArray());
        foreach ($union->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key == 'sitioweb') {
                    $union->$key = $request->$key;
                } else {
                    $union->$key = strtoupper($request->$key);
                }
            }
        }
        $result = $union->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE UNIÓN. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", ciudad:" . $m->ciudad->nombre;
                } elseif ($key == 'division_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", division:" . $m->division->nombre;
                } else {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
            }
            foreach ($union->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $union->ciudad->nombre;
                } else if ($key == 'division_id') {
                    $str = $str . ", " . $key . ": " . $value . ", division:" . $union->division->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La unión <strong>" . $union->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('union.index');
        } else {
            flash("La unión <strong>" . $union->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('union.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Union  $union
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $union = Union::find($id);
        if (count($union->asociacions) > 0) {
            flash("La unión <strong>" . $union->nombre . "</strong> no pudo ser eliminada porque tiene asociaciones asociadas.")->warning();
            return redirect()->route('union.index');
        } else {
            $result = $union->delete();
            if ($result) {
                $aud = new Auditoriafeligresia();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE UNIÓN. DATOS ELIMINADOS: ";
                foreach ($union->attributesToArray() as $key => $value) {
                    if ($key == 'ciudad_id') {
                        $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $union->ciudad->nombre;
                    } else if ($key == 'division_id') {
                        $str = $str . ", " . $key . ": " . $value . ", division:" . $union->division->nombre;
                    } else {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La unión <strong>" . $union->nombre . "</strong> fue eliminada de forma exitosa!")->success();
                return redirect()->route('union.index');
            } else {
                flash("La unión <strong>" . $union->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                return redirect()->route('union.index');
            }
        }
    }

}
