<?php

namespace App\Http\Controllers;

use App\Feligres;
use Illuminate\Http\Request;
use App\Http\Requests\FeligresRequest;
use Illuminate\Support\Facades\Auth;
use App\Iglesia;
use App\Pais;
use App\Estadocivil;
use App\Tipodocumento;

class FeligresController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $feligreses = Feligres::all();
        return view('feligresia.feligresia.feligres.list')
                        ->with('location', 'feligresia')
                        ->with('feligreses', $feligreses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $iglesias = Iglesia::all()->pluck('nombre', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $estadosciviles = Estadocivil::all()->pluck('descripcion', 'id');
        $tiposdoc = Tipodocumento::all()->pluck('descripcion', 'id');
        return view('feligresia.feligresia.feligres.create')
                        ->with('location', 'feligresia')
                        ->with('iglesias', $iglesias)
                        ->with('estadosc', $estadosciviles)
                        ->with('paises', $paises)
                        ->with('tipodoc', $tiposdoc);
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
     * @param  \App\Feligres  $feligres
     * @return \Illuminate\Http\Response
     */
    public function show(Feligres $feligres) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feligres  $feligres
     * @return \Illuminate\Http\Response
     */
    public function edit(Feligres $feligres) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feligres  $feligres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feligres $feligres) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feligres  $feligres
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feligres $feligres) {
        //
    }

}
