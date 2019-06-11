<?php

namespace App\Http\Controllers;

use App\Contacto;
use App\Feligres;
use App\Auditoriacomunicacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContactoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $contactos = Contacto::where('user_id', $u->id)->get();
        if (count($contactos) > 0) {
            foreach ($contactos as $item) {
                $item->name = $item->feligres->personanatural->primer_nombre . " " . $item->feligres->personanatural->segundo_nombre . " " . $item->feligres->personanatural->primer_apellido . " " . $item->feligres->personanatural->segundo_apellido;
                $item->igle = $item->feligres->iglesia->nombre;
                $item->ciu = $item->feligres->iglesia->ciudad->nombre;
                $item->dist = $item->feligres->iglesia->distrito->nombre;
                $item->asoci = $item->feligres->iglesia->distrito->asociacion->nombre;
            }
        }
        return view('comunicaciones.chat.contactos.list')
                        ->with('location', 'comunicacion')
                        ->with('contactos', $contactos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $feligres = Feligres::all();
        if (count($feligres) > 0) {
            foreach ($feligres as $item) {
                $item->name = $item->personanatural->primer_nombre . " " . $item->personanatural->segundo_nombre . " " . $item->personanatural->primer_apellido . " " . $item->personanatural->segundo_apellido;
                $item->igle = $item->iglesia->nombre;
                $item->ciu = $item->iglesia->ciudad->nombre;
                $item->dist = $item->iglesia->distrito->nombre;
                $item->asoci = $item->iglesia->distrito->asociacion->nombre;
            }
        }
        return view('comunicaciones.chat.contactos.create')
                        ->with('location', 'comunicacion')
                        ->with('feligres', $feligres);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $u = Auth::user();
        $exist = Contacto::where([['feligres_id', $request->feligres_id], ['user_id', $u->id]])->first();
        if ($exist != null) {
            flash("El contacto seleccionado ya existe!")->warning();
            return redirect()->route('contacto.create');
        }
        $contacto = new Contacto($request->all());
        $contacto->user_id = $u->id;
        $result = $contacto->save();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CONTACTO. DATOS: ";
            foreach ($contacto->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El contacto fue agregado de forma exitosa!")->success();
            return redirect()->route('contacto.index');
        } else {
            flash("El contacto no pudo ser agregado. Error: " . $result)->error();
            return redirect()->route('contacto.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function show(Contacto $contacto) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function edit(Contacto $contacto) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contacto $contacto) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $contacto = Contacto::find($id);
        if (count($contacto->chats) > 0) {
            flash("El contacto <strong>" . $contacto->feligres->personanatural->primer_nombre . " " . $contacto->feligres->personanatural->primer_apellido . "</strong> no puede ser eliminado porque tiene chats.!")->warning();
            return redirect()->route('contacto.index');
        } else {
            $result = $contacto->delete();
            if ($result) {
                $aud = new Auditoriacomunicacion();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE CONTACTO DATOS ELIMINADOS: ";
                foreach ($contacto->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El contacto <strong>" . $contacto->feligres->personanatural->primer_nombre . " " . $contacto->feligres->personanatural->primer_apellido . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('contacto.index');
            } else {
                flash("El contacto <strong>" . $contacto->feligres->personanatural->primer_nombre . " " . $contacto->feligres->personanatural->primer_apellido . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('contacto.index');
            }
        }
    }

}
