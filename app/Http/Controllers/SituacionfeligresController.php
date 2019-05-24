<?php

namespace App\Http\Controllers;

use App\Situacionfeligres;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use App\Historicosituacion;
use App\Auditoriafeligresia;
use App\Http\Requests\SituacionfeligresRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SituacionfeligresController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $sit = Situacionfeligres::all();
        return view('feligresia.feligresia.situacion.situaciones.list')
                        ->with('location', 'feligresia')
                        ->with('sit', $sit);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.feligresia.situacion.situaciones.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SituacionfeligresRequest $request) {
        $situacion = new Situacionfeligres($request->all());
        foreach ($situacion->attributesToArray() as $key => $value) {
            $situacion->$key = strtoupper($value);
        }
        $result = $situacion->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE SITUACIÓN FELIGRES. DATOS: ";
            foreach ($situacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La situación <strong>" . $situacion->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('situacion.index');
        } else {
            flash("La situación <strong>" . $situacion->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('situacion.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Situacionfeligres  $situacionfeligres
     * @return \Illuminate\Http\Response
     */
    public function show(Situacionfeligres $situacionfeligres) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Situacionfeligres  $situacionfeligres
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $situacion = Situacionfeligres::find($id);
        return view('feligresia.feligresia.situacion.situaciones.edit')
                        ->with('location', 'feligresia')
                        ->with('situacion', $situacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Situacionfeligres  $situacionfeligres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $situacion = Situacionfeligres::find($id);
        $m = new Situacionfeligres($situacion->attributesToArray());
        foreach ($situacion->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $situacion->$key = strtoupper($request->$key);
            }
        }
        $result = $situacion->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE  SITUACIÓN FELIGRES. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($situacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La situación <strong>" . $situacion->nombre . "</strong> fue modificada de forma exitosa!")->success();
            return redirect()->route('situacion.index');
        } else {
            flash("La situación <strong>" . $situacion->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('situacion.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Situacionfeligres  $situacionfeligres
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $situacion = Situacionfeligres::find($id);
//        if (count($situacion->ciudades) > 0) {
//            flash("El Departamento <strong>" . $situacion->nombre . "</strong> no pudo ser eliminado porque tiene ciudades/municipios asociados.")->warning();
//            return redirect()->route('estado.index');
//        } else {
        $result = $situacion->delete();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE SITUACIÓN FELIGRES. DATOS ELIMINADOS: ";
            foreach ($situacion->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La situacion <strong>" . $situacion->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('situacion.index');
        } else {
            flash("La situacion <strong>" . $situacion->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('situacion.index');
        }
//       }
    }

    /**
     * Show the form for make operations width a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request) {
        $feligres = Feligres::find($request->feligres_id);
        $sit_ant = $feligres->situacionfeligres_id;
        $m = new Feligres($feligres->attributesToArray());
        $feligres->situacionfeligres_id = $request->situacionfeligres_id;
        $feligres->estado_actual = $request->estado_actual;
        $result = $feligres->save();
        if ($result) {
            if ($sit_ant != $feligres->situacionfeligres_id) {
                $hist_sit = new Historicosituacion();
                $hist_sit->situacionfeligres_id = $sit_ant;
                $hist_sit->feligres_id = $feligres->id;
                $hist_sit->save();
            }
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "ACTUALIZACIÓN DE  SITUACIÓN FELIGRES. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($feligres->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La actualización fue realizada de forma exitosa!")->success();
            return redirect()->route('admin.situacion');
        } else {
            flash("La actualización no pudo ser realizada. Error: " . $result)->error();
            return redirect()->route('admin.situacion');
        }
    }

    /**
     * Show the form for make operations width a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getfeligres(Request $request) {
        $persona = Persona::where('numero_documento', $request->id)->first();
        if ($persona == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada!")->error();
            return redirect()->route('pastor.index');
        }
        $personanatural = Personanatural::where('persona_id', $persona->id)->first();
        if ($personanatural != null) {
            $feligres = Feligres::where('personanatural_id', $personanatural->id)->first();
        } else {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como persona natural!")->error();
            return redirect()->route('pastor.index');
        }
        if ($feligres == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como feligres!")->error();
            return redirect()->route('pastor.index');
        }
        $feligres->personanatural;
        $situacion = Situacionfeligres::all()->pluck('nombre', 'id');
        $estadom = ['ACTIVO' => 'ACTIVO', 'INACTIVO' => 'INACTIVO', 'FALLECIDO' => 'FALLECIDO',
            'PARADERO DESCONOCIDO' => 'PARADERO DESCONOCIDO', 'RETIRADO' => 'RETIRADO'];
        return view('feligresia.feligresia.situacion.actualizar_situacion.list')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres)
                        ->with('situacion', $situacion)
                        ->with('estadom', $estadom);
    }

}
