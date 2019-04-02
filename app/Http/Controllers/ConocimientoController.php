<?php

namespace App\Http\Controllers;

use App\Conocimiento;
use App\Feligres;
use App\Categorialabor;
use App\Auditoriafeligresia;
use App\Http\Requests\ConocimientoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ConocimientoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $feligres = Feligres::find($id);
        $conocimientos = Conocimiento::where('feligres_id', $id)->get();
        $conocimientos->each(function($item) {
            $item->feligres;
        });
        return view('feligresia.feligresia.experiencia.conocimiento.list')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres)
                        ->with('conocimientos', $conocimientos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $feligres = Feligres::find($id);
        return view('feligresia.feligresia.experiencia.conocimiento.create')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConocimientoRequest $request) {
        $conocimiento = new Conocimiento($request->all());
        foreach ($conocimiento->attributesToArray() as $key => $value) {
            $conocimiento->$key = strtoupper($value);
        }
        $result = $conocimiento->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CONOCIMIENTO. DATOS: ";
            foreach ($conocimiento->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El conocimiento <strong>" . $conocimiento->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('conocimiento.index2', $request->feligres_id);
        } else {
            flash("El conocimiento <strong>" . $conocimiento->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('conocimiento.index2', $request->feligres->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conocimiento  $conocimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Conocimiento $conocimiento) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conocimiento  $conocimiento
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $conocimiento = Conocimiento::find($id);
        return view('feligresia.feligresia.experiencia.conocimiento.edit')
                        ->with('location', 'feligresia')
                        ->with('conocimiento', $conocimiento);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conocimiento  $conocimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $conocimiento = Conocimiento::find($id);
        $m = new Conocimiento($conocimiento->attributesToArray());
        foreach ($conocimiento->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $conocimiento->$key = strtoupper($request->$key);
            }
        }
        $result = $conocimiento->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE CONOCIMIENTO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($conocimiento->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El conocimiento <strong>" . $conocimiento->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('conocimiento.index2', $conocimiento->feligres_id);
        } else {
            flash("El Conocimiento <strong>" . $conocimiento->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('conocimiento.index2', $conocimiento->feligres_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conocimiento  $conocimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $conocimiento = Conocimiento::find($id);
//        if (count($conocimiento->ciudades) > 0) {
//            flash("El Departamento <strong>" . $conocimiento->nombre . "</strong> no pudo ser eliminado porque tiene ciudades/municipios asociados.")->warning();
//            return redirect()->route('estado.index');
//        } else {
        $result = $conocimiento->delete();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE CONOCIMIENTO. DATOS ELIMINADOS: ";
            foreach ($conocimiento->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El conocimiento <strong>" . $conocimiento->nombre . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('conocimiento.index2', $conocimiento->feligres_id);
        } else {
            flash("El conocimiento <strong>" . $conocimiento->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('conocimiento.index2', $conocimiento->feligres_id);
        }
//       }
    }

}
