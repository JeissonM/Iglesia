<?php

namespace App\Http\Controllers;

use App\Pedidosoracion;
use App\Feligres;
use App\Ciudad;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
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
    public function destroy(Pedidosoracion $pedidosoracion) {
        //
    }

}
