<?php

namespace App\Http\Controllers;

use App\Recursosministerial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecursosministerialController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $recursos = Recursosministerial::all();
        if (count($recursos) > 0) {
            $recursos->each(function($item) {
                $item->recursosministerialitems;
            });
        }
        return view('gestion_documental.recursos_ministeriales.list')
                        ->with('location', 'gestion-documental')
                        ->with('recursos', $recursos);
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
     * @param  \App\Recursosministerial  $recursosministerial
     * @return \Illuminate\Http\Response
     */
    public function show(Recursosministerial $recursosministerial) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recursosministerial  $recursosministerial
     * @return \Illuminate\Http\Response
     */
    public function edit(Recursosministerial $recursosministerial) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recursosministerial  $recursosministerial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recursosministerial $recursosministerial) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recursosministerial  $recursosministerial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recursosministerial $recursosministerial) {
        //
    }

}
