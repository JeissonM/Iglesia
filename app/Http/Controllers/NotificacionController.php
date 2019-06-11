<?php

namespace App\Http\Controllers;

use App\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = Auth::user();
        $not = Notificacion::where('user_id', $user->id)->get();
        $notificaciones = null;
        $total = 0;
        $total = count($not);
        if ($total > 0) {
            foreach ($not as $n) {
                $notificaciones[] = $n;
            }
        }
        return view('comunicaciones.notificacion.list')
                        ->with('location', 'comunicacion')
                        ->with('notificaciones', $notificaciones);
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
     * @param  \App\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function show(Notificacion $notificacion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Notificacion $notificacion) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notificacion $notificacion) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notificacion $notificacion) {
        //
    }

}
