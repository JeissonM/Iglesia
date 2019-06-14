<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use Illuminate\Support\Facades\Auth;

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
    public function operaciones(Request $request) {
        $persona = Persona::where('numero_documento', $request->id)->first();
        if ($persona == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada!")->error();
            return redirect()->route('admin.feligresia');
        }
        $personanatural = Personanatural::where('persona_id', $persona->id)->first();
        if ($personanatural != null) {
            $feligres = Feligres::where('personanatural_id', $personanatural->id)->first();
        } else {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como persona natural!")->error();
            return redirect()->route('admin.feligresia');
        }
        if ($feligres == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como feligres!")->error();
            return redirect()->route('admin.feligresia');
        }
        $feligres->personanatural;
        return view('feligresia.feligresia.experiencia.menu')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres);
    }

    /**
     * Show the form for make operations width a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function experienciafeligres() {
        $u = Auth::user();
        $persona = Persona::where('numero_documento', $u->identificacion)->first();
        if ($persona == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada!")->error();
            return redirect()->route('admin.feligresia');
        }
        $personanatural = Personanatural::where('persona_id', $persona->id)->first();
        if ($personanatural != null) {
            $feligres = Feligres::where('personanatural_id', $personanatural->id)->first();
        } else {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como persona natural!")->error();
            return redirect()->route('admin.feligresia');
        }
        if ($feligres == null) {
            flash("<strong>La Persona</strong> consultada no se encuentra registrada como feligres!")->error();
            return redirect()->route('admin.feligresia');
        }
        $feligres->personanatural;
        return view('feligresia.feligresia.experiencia.menu')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres);
    }

    /**
     * Show the view menu gestión documental
     *
     * @return \Illuminate\Http\Response
     */
    public function gestiondocumental() {
        return view('menu.gestiondocumental')->with('location', 'gestion-documental');
    }

    /**
     * Show the view menu comunicacion
     *
     * @return \Illuminate\Http\Response
     */
    public function comunicacion() {
        return view('menu.comunicacion')->with('location', 'comunicacion');
    }

    /**
     * Show the view menu editorial
     *
     * @return \Illuminate\Http\Response
     */
    public function editorial() {
        return view('menu.editorial')->with('location', 'gestion-documental');
    }

    /**
     * Show the view menu institucional
     *
     * @return \Illuminate\Http\Response
     */
    public function institucional() {
        return view('menu.institucional')->with('location', 'comunicacion');
    }

    /**
     * Show the view menu auditoria
     *
     * @return \Illuminate\Http\Response
     */
    public function auditoria() {
        return view('menu.auditoria')->with('location', 'auditoria');
    }

}
