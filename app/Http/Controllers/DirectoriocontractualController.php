<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Categorialabor;
use App\Feligres;

class DirectoriocontractualController extends Controller {

    public function index() {
        $fel = Feligres::all();
        $feligreses = null;
        if (count($fel) > 0) {
            foreach ($fel as $f) {
                $f->pn = $f->personanatural->primer_nombre . " " . $f->personanatural->segundo_nombre . " " . $f->personanatural->primer_apellido . " " . $f->personanatural->segundo_apellido;
                $feligreses[] = $f;
            }
        }
        $cat = Categorialabor::all()->pluck('nombre', 'id');
        return view('comunicaciones.directorio_contractual.list')
                        ->with('location', 'comunicacion')
                        ->with('feligreses', $feligreses)
                        ->with('categorias', $cat);
    }

    public function show($id) {
        $f = Feligres::find($id);
        $experiencia = $f->experiencialabors;
        $conocimientos = $f->conocimientos;
        return view('comunicaciones.directorio_contractual.show')
                        ->with('location', 'comunicacion')
                        ->with('f', $f)
                        ->with('experiencia', $experiencia)
                        ->with('conocimientos', $conocimientos);
    }

}
