<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anuncio;
use App\Persona;
use App\Personanatural;
use App\Feligres;

class AnunciosappController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function anunciosVigentes() {
        $anuncios = Anuncio::where([['estado', 'VIGENTE'], ['tipo', 'ASOCIACION']])->get();
        if (count($anuncios) > 0) {
            $data = null;
            foreach ($anuncios as $a) {
                switch ($a->tipo) {
                    case 'ASOCIACION':
                        if ($a->asociacion_id != null) {
                            $a->asociacionn = $a->asociacion->nombre;
                        } else {
                            $a->asociacionn = "";
                        }
                        break;
                    case 'DISTRITO':
                        if ($a->distrito_id != null) {
                            $a->distriton = $a->distrito->nombre;
                        } else {
                            $a->distriton = "";
                        }
                        break;
                    case 'LOCAL':
                        if ($a->iglesia_id != null) {
                            $a->iglesian = $a->iglesia->nombre;
                        } else {
                            $a->iglesian = "";
                        }
                        break;
                    default :
                        $a->asociacionn = "";
                        $a->distriton = "";
                        $a->iglesian = "";
                }
                $a->si = true;
                $a->no = true;
                if ($a->imagen != "NO") {
                    $a->path = config('app.url') . "/docs/anuncios/" . $a->imagen;
                    $a->no = false;
                } else {
                    $a->si = false;
                    $a->path = "";
                }
                $data[] = $a;
            }
            return response()->json(['data' => $data, 'mensaje' => 'Datos encontrados'], 200);
        } else {
            return response()->json(['data' => 'null', 'mensaje' => 'No hay anuncios disponibles'], 200);
        }
        return response()->json(['data' => 'null', 'mensaje' => 'Error inesperado'], 500);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
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
        //
    }

    /*
     * anuncios vigentes locales
     */

    public function anunciosLocales($id) {
        $pgs = Persona::where('numero_documento', $id)->get();
        if (count($pgs) > 0) {
            $iglesias = null;
            $distritos = null;
            foreach ($pgs as $p) {
                $pns = $p->personanaturals;
                if (count($pns) > 0) {
                    foreach ($pns as $pn) {
                        $fs = $pn->feligres;
                        if (count($fs) > 0) {
                            foreach ($fs as $f) {
                                $iglesias[$f->iglesia_id] = $f->iglesia_id;
                                $distritos[$f->iglesia->distrito_id] = $f->iglesia->distrito_id;
                            }
                        }
                    }
                }
            }
            $anuncios = null;
            if ($distritos != null) {
                foreach ($distritos as $d) {
                    $and = Anuncio::where([['estado', 'VIGENTE'], ['tipo', 'DISTRITO'], ['distrito_id', $d]])->get();
                    if (count($and) > 0) {
                        foreach ($and as $a) {
                            $anuncios[] = $a;
                        }
                    }
                }
            }
            if ($iglesias != null) {
                foreach ($iglesias as $i) {
                    $ani = Anuncio::where([['estado', 'VIGENTE'], ['tipo', 'LOCAL'], ['iglesia_id', $i]])->get();
                    if (count($ani) > 0) {
                        foreach ($ani as $ai) {
                            $anuncios[] = $ai;
                        }
                    }
                }
            }
            if ($anuncios!=null) {
                $data = null;
                foreach ($anuncios as $af) {
                    $af->asociacionn = "";
                    switch ($af->tipo) {
                        case 'ASOCIACION':
                            break;
                        case 'DISTRITO':
                            if ($af->distrito_id != null) {
                                $af->distriton = $af->distrito->nombre;
                            } else {
                                $af->distriton = "";
                            }
                            break;
                        case 'LOCAL':
                            if ($af->iglesia_id != null) {
                                $af->iglesian = $af->iglesia->nombre;
                            } else {
                                $af->iglesian = "";
                            }
                            break;
                        default :
                            $af->asociacionn = "";
                            $af->distriton = "";
                            $af->iglesian = "";
                    }
                    $af->si = true;
                    $af->no = true;
                    if ($af->imagen != "NO") {
                        $af->path = config('app.url') . "/docs/anuncios/" . $af->imagen;
                        $af->no = false;
                    } else {
                        $af->si = false;
                        $af->path = "";
                    }
                    if ($af->tipo != "ASOCIACION") {
                        $data[] = $af;
                    }
                }
                return response()->json(['data' => $data, 'mensaje' => 'Datos encontrados'], 200);
            } else {
                return response()->json(['data' => 'null', 'mensaje' => 'No hay anuncios disponibles'], 200);
            }
        } else {
            return response()->json(['data' => 'null', 'mensaje' => 'No hay anuncios disponibles'], 200);
        }
        return response()->json(['data' => 'null', 'mensaje' => 'Error inesperado'], 500);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function anunciosTodos() {
        $anuncios = Anuncio::all();
        if (count($anuncios) > 0) {
            $data = null;
            foreach ($anuncios as $a) {
                switch ($a->tipo) {
                    case 'ASOCIACION':
                        if ($a->asociacion_id != null) {
                            $a->asociacionn = $a->asociacion->nombre;
                        } else {
                            $a->asociacionn = "";
                        }
                        break;
                    case 'DISTRITO':
                        if ($a->distrito_id != null) {
                            $a->distriton = $a->distrito->nombre;
                        } else {
                            $a->distriton = "";
                        }
                        break;
                    case 'LOCAL':
                        if ($a->iglesia_id != null) {
                            $a->iglesian = $a->iglesia->nombre;
                        } else {
                            $a->iglesian = "";
                        }
                        break;
                    default :
                        $a->asociacionn = "";
                        $a->distriton = "";
                        $a->iglesian = "";
                }
                $a->si = true;
                $a->no = true;
                if ($a->imagen != "NO") {
                    $a->path = config('app.url') . "/docs/anuncios/" . $a->imagen;
                    $a->no = false;
                } else {
                    $a->si = false;
                    $a->path = "";
                }
                $data[] = $a;
            }
            return response()->json(['data' => $data, 'mensaje' => 'Datos encontrados'], 200);
        } else {
            return response()->json(['data' => 'null', 'mensaje' => 'No hay anuncios disponibles'], 200);
        }
        return response()->json(['data' => 'null', 'mensaje' => 'Error inesperado'], 500);
    }

}
