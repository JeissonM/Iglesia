<?php

namespace App\Http\Controllers;

use App\Itinerario;
use App\Asociacion;
use App\Itinerariodetalle;
use App\Periodo;
use App\Auditoriagestiondocumental;
use App\Http\Requests\ItinerarioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ItinerarioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $itine = Itinerario::all();
        return view('gestion_documental.itinerario.list')
                        ->with('location', 'gestion-documental')
                        ->with('itine', $itine);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        $per = Periodo::all()->sortByDesc('id');
        $periodos = null;
        foreach ($per as $pe) {
            $periodos[$pe->id] = $pe->etiqueta . " - " . $pe->fechainicio . " - " . $pe->fechafin;
        }
        return view('gestion_documental.itinerario.create')
                        ->with('location', 'gestion-documental')
                        ->with('periodos', $periodos)
                        ->with('asociaciones', $asociaciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItinerarioRequest $request) {
        $itinerario = new Itinerario($request->all());
        foreach ($itinerario->attributesToArray() as $key => $value) {
            $itinerario->$key = strtoupper($value);
        }
        $result = $itinerario->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriagestiondocumental();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ITINERARIO. DATOS: ";
            foreach ($itinerario->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Itinerario <strong>" . $itinerario->titulo . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('itinerario.index');
        } else {
            flash("El Itinerario <strong>" . $itinerario->titulo . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('itinerario.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Itinerario  $itinerario
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $itinerario = Itinerario::find($id);
        $detalles = Itinerariodetalle::where('itinerario_id', $id)->orderBy('orden','asc')->get();
        return view('gestion_documental.itinerario.show')
                        ->with('location', 'gestion-documental')
                        ->with('itinerario', $itinerario)
                        ->with('detalles', $detalles);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Itinerario  $itinerario
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $itinerario = Itinerario::find($id);
        $periodos = Periodo::all()->pluck('etiqueta', 'id');
        return view('gestion_documental.itinerario.edit')
                        ->with('location', 'gestion-documental')
                        ->with('itinerario', $itinerario)
                        ->with('periodos', $periodos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Itinerario  $itinerario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $itinerario = Itinerario::find($id);
        $m = new Itinerario($itinerario->attributesToArray());
        foreach ($itinerario->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $itinerario->$key = strtoupper($request->$key);
            }
        }
        $result = $itinerario->save();
        if ($result) {
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE ITINERARIO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($itinerario->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El itinerario <strong>" . $itinerario->titulo . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('itinerario.index');
        } else {
            flash("El itinerario <strong>" . $itinerario->titulo . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('itinerario.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Itinerario  $itinerario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $itinerario = Itinerario::find($id);
        if (count($itinerario->itinerariodetalles) > 0) {
            flash("El evento <strong>" . $itinerario->titulo . "</strong> no pudo ser eliminado porque tiene detalles asociados.")->warning();
            return redirect()->route('itinerario.index');
        } else {
            $result = $itinerario->delete();
            if ($result) {
                $aud = new Auditoriagestiondocumental();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE ITINERARIO. DATOS ELIMINADOS: ";
                foreach ($itinerario->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El itinerario <strong>" . $itinerario->titulo . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('itinerario.index');
            } else {
                flash("El itinerario <strong>" . $itinerario->titulo . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('itinerario.index');
            }
        }
    }

    /**
     * show all resource from a asociacion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDistritos($id) {
        $asociacion = Asociacion::find($id);
        $distritos = $asociacion->distritos;
        if (count($distritos) > 0) {
            $distritosf = null;
            foreach ($distritos as $value) {
                $obj["id"] = $value->id;
                $obj["value"] = $value->nombre;
                $distritosf[] = $obj;
            }
            return json_encode($distritosf);
        } else {
            return "null";
        }
    }

}
