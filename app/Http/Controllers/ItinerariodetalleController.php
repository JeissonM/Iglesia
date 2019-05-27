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
        $h = ['0000' => '00:00 M', '0030' => '00:30 M', '0100' => '01:00 AM', '0130' => '01:30 AM', '0200' => '02:00 AM', '0230' => '02:30 AM',
            '0300' => '03:00 AM', '0330' => '03:30 AM', '0400' => '04:00 AM', '0430' => '04:30 AM', '0500' => '05:00 AM', '0530' => '05:30 AM',
            '0600' => '06:00 AM', '0630' => '06:30 AM', '0700' => '07:00 AM', '0730' => '07:30 AM', '0800' => '08:00 AM', '0830' => '08:30 AM',
            '0900' => '09:00 AM', '0930' => '09:30 AM', '1000' => '10:00 AM', '1030' => '10:30 AM', '1100' => '11:00 AM', '1130' => '11:30 AM',
            '1200' => '12:00 M', '1230' => '12:30 M', '1300' => '01:00 PM', '1330' => '01:30 PM', '1400' => '02:00 PM', '1430' => '02:30 PM',
            '1500' => '03:00 PM', '1530' => '03:30 PM', '1600' => '04:00 PM', '1630' => '04:30 PM', '1700' => '05:00 PM', '1730' => '05:30 PM',
            '1800' => '06:00 PM', '1830' => '06:30 PM', '1900' => '07:00 PM', '1930' => '07:30 PM', '2000' => '08:00 PM', '2030' => '08:30 PM',
            '2100' => '09:00 PM', '2130' => '09:30 PM', '2200' => '10:00 PM', '2230' => '10:30 PM', '2300' => '11:00 PM', '2330' => '11:30 PM',
        ];
        return view('gestion_documental.itinerario.itinerario_detalles.create')
                        ->with('location', 'gestion-documental')
                        ->with('itinerario', $itinerario)
                        ->with('h', $h);
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
