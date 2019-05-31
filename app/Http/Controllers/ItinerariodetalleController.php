<?php

namespace App\Http\Controllers;

use App\Itinerario;
use App\Itinerariodetalle;
use App\Auditoriagestiondocumental;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ItinerariodetalleRequest;
use Illuminate\Http\Request;

class ItinerariodetalleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $itinerario = Itinerario::find($id);
        $detalles = $itinerario->itinerariodetalles;
        return view('gestion_documental.itinerario.itinerario_detalles.list')
                        ->with('location', 'gestion-documental')
                        ->with('itinerario', $itinerario)
                        ->with('detalles', $detalles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItinerariodetalleRequest $request) {
        $detalle = new Itinerariodetalle($request->all());
        foreach ($detalle->attributesToArray() as $key => $value) {
            $detalle->$key = strtoupper($value);
        }
        $result = $detalle->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriagestiondocumental();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE DETALLES DE ITINERARIO. DATOS: ";
            foreach ($detalle->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El detalle <strong>" . $detalle->descripcion . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('itinerariodetalle.inicio', $request->itinerario_id);
        } else {
            flash("El detalle <strong>" . $detalle->descripcion . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('itinerariodetalle.inicio', $request->itinerario_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $itinerario = Itinerario::find($id);
        return view('gestion_documental.itinerario.itinerario_detalles.create')
                        ->with('location', 'gestion-documental')
                        ->with('itinerario', $itinerario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $detalle = Itinerariodetalle::find($id);
//        if (count($detalle->iglesias) > 0) {
//            flash("El distrito <strong>" . $detalle->nombre . "</strong> no pudo ser eliminado porque tiene iglesias asociadas.")->warning();
//            return redirect()->route('distrito.index');
//        } else {
        $result = $detalle->delete();
        if ($result) {
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE DETALLES DE ITINERARIO. DATOS ELIMINADOS: ";
            foreach ($detalle->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El detalle <strong>" . $detalle->descripcion . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('itinerariodetalle.inicio', $detalle->itinerario_id);
        } else {
            flash("El detalle <strong>" . $detalle->descripcion . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('itinerariodetalle.inicio', $detalle->itinerario_id);
        }
        //}
    }

}
