<?php

namespace App\Http\Controllers;

use App\Experiencialabor;
use App\Feligres;
use App\Categorialabor;
use App\Auditoriafeligresia;
use App\Http\Requests\ExperiencialaborRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ExperiencialaborController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $feligres = Feligres::find($id);
        $experiencias = Experiencialabor::where('feligres_id', $id)->get();
        $experiencias->each(function($item) {
            $item->feligres;
            $item->labor;
        });
        return view('feligresia.feligresia.experiencia.experiencia_labor.list')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres)
                        ->with('experiencias', $experiencias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $feligres = Feligres::find($id);
        $categorias = Categorialabor::all()->pluck('nombre', 'id');
        return view('feligresia.feligresia.experiencia.experiencia_labor.create')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres)
                        ->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExperiencialaborRequest $request) {
        $experiencia = new Experiencialabor($request->all());
        foreach ($experiencia->attributesToArray() as $key => $value) {
            $experiencia->$key = strtoupper($value);
        }
        if ($experiencia->fechainicio == "") {
            $experiencia->fechainicio = null;
        }
        if ($experiencia->fechafin == "") {
            $experiencia->fechafin = null;
        }
        $result = $experiencia->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE EXPERIENCIA LABOR. DATOS: ";
            foreach ($experiencia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La experiencia <strong>" . $experiencia->labor->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('experiencialabor.index2', $request->feligres_id);
        } else {
            flash("La experiencia <strong>" . $experiencia->labor->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('experiencialabor.index2', $request->feligres->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Experiencialabor  $experiencialabor
     * @return \Illuminate\Http\Response
     */
    public function show(Experiencialabor $experiencialabor) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Experiencialabor  $experiencialabor
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $experiencia = Experiencialabor::find($id);
        $categorias = Categorialabor::all()->pluck('nombre', 'id');
        return view('feligresia.feligresia.experiencia.experiencia_labor.edit')
                        ->with('location', 'feligresia')
                        ->with('experiencia', $experiencia)
                        ->with('categorias', $categorias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Experiencialabor  $experiencialabor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $experiencia = Experiencialabor::find($id);
        $m = new Experiencialabor($experiencia->attributesToArray());
        foreach ($experiencia->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $experiencia->$key = strtoupper($request->$key);
            }
        }
        if ($experiencia->fechainicio == "") {
            $experiencia->fechainicio = null;
        }
        if ($experiencia->fechafin == "") {
            $experiencia->fechafin = null;
        }
        $result = $experiencia->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE EXPERIENCIA LABOR. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($experiencia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La experiencia <strong>" . $experiencia->labor->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('experiencialabor.index2', $experiencia->feligres_id);
        } else {
            flash("La experiencia <strong>" . $experiencia->labor->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('experiencialabor.index2', $experiencia->feligres_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Experiencialabor  $experiencialabor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $experiencia = Experiencialabor::find($id);
//        if (count($experiencia->ciudades) > 0) {
//            flash("El Departamento <strong>" . $experiencia->nombre . "</strong> no pudo ser eliminado porque tiene ciudades/municipios asociados.")->warning();
//            return redirect()->route('estado.index');
//        } else {
        $result = $experiencia->delete();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE EXPERIENCIA LABOR. DATOS ELIMINADOS: ";
            foreach ($experiencia->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La expriencia <strong>" . $experiencia->labor->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('experiencialabor.index2', $experiencia->feligres_id);
        } else {
            flash("La experiencia <strong>" . $experiencia->labor->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('experiencialabor.index2', $experiencia->feligres_id);
        }
//       }
    }

    /**
     * show all resource from a categorie.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getlabores($id) {
        $categoria = Categorialabor::find($id);
        $labores = $categoria->labors;
        if (count($labores) > 0) {
            $laboresf = null;
            foreach ($labores as $value) {
                $obj["id"] = $value->id;
                $obj["value"] = $value->nombre;
                $laboresf[] = $obj;
            }
            return json_encode($laboresf);
        } else {
            return "null";
        }
    }

}
