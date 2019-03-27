<?php

namespace App\Http\Controllers;

use App\Division;
use Illuminate\Http\Request;
use App\Http\Requests\DivisionRequest;
use App\Ciudad;

class DivisionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $divisiones = Division::all();
        $divisiones->each(function($item) {
            $item->ciudad;
        });
        return view('feligresia.estructura_eclesiastica.divisiones.list')
                        ->with('location', 'feligresia')
                        ->with('divisiones', $divisiones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() { 
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.divisiones.create')
                        ->with('location', 'feligresia')
                        ->with('ciudades', $ciudades);
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
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Division $division) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division) {
        //
    }

}
