<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Personanatural;
use App\Feligres;

class MenuController extends Controller {

    /**
     * Show the view menu usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function usuarios() {
        return view('menu.usuarios')->with('location', 'usuarios');
    }

    /**
     * Show the view menu feligresia.
     *
     * @return \Illuminate\Http\Response
     */
    public function feligresia() {
        return view('menu.feligresia')->with('location', 'feligresia');
    }
    
     /**
     * Show the view menu situaciones.
     *
     * @return \Illuminate\Http\Response
     */
    public function situacion() {
        return view('menu.situacion')->with('location', 'feligresia');
    }

    /**
     * Show the form for make operations width a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function operaciones() {
        $persona = Persona::where('numero_documento', $_POST["id"])->first();
        if ($persona == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada!")->error();
            return redirect()->route('pastor.index');
        }
        $personanatural = Personanatural::where('persona_id', $persona->id)->first();
        if ($personanatural != null) {
            $feligres = Feligres::where('personanatural_id', $personanatural->id)->first();
        } else {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como persona natural!")->error();
            return redirect()->route('pastor.index');
        }
        if ($feligres == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como feligres!")->error();
            return redirect()->route('pastor.index');
        }
        $feligres->personanatural;
        return view('feligresia.feligresia.experiencia.menu')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres);
    }

}
