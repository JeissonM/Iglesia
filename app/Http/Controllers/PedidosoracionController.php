<?php

namespace App\Http\Controllers;

use App\Pedidosoracion;
use App\Feligres;
use App\Ciudad;
use App\Persona;
use App\Personanatural;
use App\Auditoriacomunicacion;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PedidosoracionRequest;
use Illuminate\Http\Request;

class PedidosoracionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pedidos = Pedidosoracion::all();
        $u = Auth::user();
        $id = $u->identificacion;
        return view('comunicaciones.pedidos_oracion.list')
                        ->with('location', 'comunicaciones')
                        ->with('pedidos', $pedidos)
                        ->with('id', $id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        return view('comunicaciones.pedidos_oracion.create')
                        ->with('location', 'comunicaciones')
                        ->with('ciudades', $ciudades);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PedidosoracionRequest $request) {
        $pedido = new Pedidosoracion();
        $pedido->tipo = $request->tipo;
        $pedido->pedido = $request->pedido;
        $pedido->ciudad_id = $request->ciudad_id;
        if ($request->tipo == "PRIVADO") {
            foreach ($pedido->attributesToArray() as $key => $value) {
                $pedido->$key = strtoupper($value);
            }
            $u = Auth::user();
            $p = Persona::where('numero_documento', $u->identificacion)->first();
            if ($p != null) {
                $pn = Personanatural::where('persona_id', $p->id)->first();
                if ($pn !== null) {
                    $f = Feligres::where([['personanatural_id', $pn->id], ['estado_actual', 'ACTIVO']])->first();
                    if ($f != null) {
                        $pedido->feligres_id = $f->id;
                        $pedido->correo = $f->personanatural->persona->mail;
                    }
                }
            } else {
                flash('No tiene permisos para acceder a esta función.')->warning();
                return redirect()->route('admin.comunicaciones');
            }
        } else {
            $pedido->persona = $request->persona;
            $pedido->correo = $request->correo;
        }
        foreach ($pedido->attributesToArray() as $key => $value) {
            $pedido->$key = strtoupper($value);
        }
        $result = $pedido->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE PEDIDO DE ORACIÓN. DATOS: ";
            foreach ($pedido->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El Pedido fue almacenado de forma exitosa!")->success();
            return redirect()->route('pedidosoracion.index');
        } else {
            flash("El Pedido no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('pedidosoracion.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedidosoracion  $pedidosoracion
     * @return \Illuminate\Http\Response
     */
    public function show(Pedidosoracion $pedidosoracion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedidosoracion  $pedidosoracion
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedidosoracion $pedidosoracion) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedidosoracion  $pedidosoracion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedidosoracion $pedidosoracion) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedidosoracion  $pedidosoracion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $pedido = Pedidosoracion::find($id);
            $result = $pedido->delete();
            if ($result) {
                $aud = new Auditoriacomunicacion();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE PEDIDO DE ORACCIÓN. DATOS ELIMINADOS: ";
                foreach ($pedido->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El pedido fue eliminado de forma exitosa!")->success();
                return redirect()->route('pedidosoracion.index');
            } else {
                flash("El pedido no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('pedidosoracion.index');
            }
    }

    public function cambiarestado(Request $request){
        $pedido = Pedidosoracion::find($request->pedido_id);
        $pedido->estado =$request->estado;
        $result = $pedido->save();
        if ($result) {
                $aud = new Auditoriacomunicacion();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "CAMBIO DE PEDIDO DE ORACCIÓN. DATOS ELIMINADOS: ";
                foreach ($pedido->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El estado del pedido de oración fue cambiado de forma exitosa!")->success();
                return redirect()->route('pedidosoracion.index');
            } else {
                flash("Elestado del pedido de oración no pudo ser cambiado. Error: " . $result)->error();
                return redirect()->route('pedidosoracion.index');
            }
    }
}
