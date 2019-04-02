<?php

namespace App\Http\Controllers;

use App\Pastor;
use App\Persona;
use App\Personanatural;
use App\Feligres;
use App\Asociacion;
use App\Pais;
use App\Iglesia;
use App\Distrito;
use App\Tipodocumento;
use App\Estadocivil;
use App\Auditoriafeligresia;
use App\Http\Requests\PastorRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PastorController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pastores = Pastor::all();
        return view('feligresia.feligresia.pastores.list')
                        ->with('location', 'feligresia')
                        ->with('pastores', $pastores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $iglesias = Iglesia::all()->pluck('nombre', 'id');
        $paises = Pais::all()->pluck('nombre', 'id');
        $distritos = Distrito::all()->pluck('nombre', 'id');
        $estadosciviles = Estadocivil::all()->pluck('descripcion', 'id');
        $tiposdoc = Tipodocumento::all()->pluck('descripcion', 'id');
        return view('feligresia.feligresia.pastores.create')
                        ->with('location', 'feligresia')
                        ->with('iglesias', $iglesias)
                        ->with('estadosc', $estadosciviles)
                        ->with('paises', $paises)
                        ->with('distritos', $distritos)
                        ->with('tipodoc', $tiposdoc);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PastorRequest $request) {
        $pastor = new Pastor($request->all());
        foreach ($pastor->attributesToArray() as $key => $value) {
            $pastor->$key = strtoupper($value);
        }
        if ($pastor->fecha_jubilacion == "") {
            $pastor->fecha_jubilacion = null;
        }
        $result = $pastor->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE PASTOR. DATOS: ";
            foreach ($pastor->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El pastor <strong>" . $pastor->personanatural->primer_nombre . " " . $pastor->personanatural->primer_apellido . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('pastor.index');
        } else {
            flash("El estado civil <strong>" . $pastor->personanatural->primer_nombre . " " . $pastor->personanatural->apellido_apellido . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('pastor.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pastor  $pastor
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $pastor = Pastor::find($id);
        return view('feligresia.feligresia.pastores.show')
                        ->with('location', 'feligresia')
                        ->with('pastor', $pastor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pastor  $pastor
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $pastor = Pastor::find($id);
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        return view('feligresia.feligresia.pastores.edit')
                        ->with('location', 'feligresia')
                        ->with('pastor', $pastor)
                        ->with('asociaciones', $asociaciones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pastor  $pastor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $pastor = Pastor::find($id);
        $m = new Pastor($pastor->attributesToArray());
        foreach ($pastor->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $pastor->$key = strtoupper($request->$key);
            }
        }
        if ($pastor->fecha_jubilacion == "") {
            $pastor->fecha_jubilacion = null;
        }
        $result = $pastor->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE PASTOR. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($pastor->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El pastor <strong>" . $pastor->personanatural->primer_nombre . " " . $pastor->personanatural->primer_apellido . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('pastor.index');
        } else {
            flash("El pastor <strong>" . $pastor->personanatural->primer_nombre . " " . $pastor->personanatural->primer_apellido . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('pastor.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pastor  $pastor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $pastor = Pastor::find($id);
//        if (count($pastor->personanaturals) > 0) {
//            flash("El estado civil <strong>" . $pastor->descripcion . "</strong> no pudo ser eliminado porque tiene personas asociadss.")->warning();
//            return redirect()->route('estadocivil.index');
//        } else {
        $result = $pastor->delete();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE PASTOR. DATOS: ";
            foreach ($pastor->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El pastor <strong>" . $pastor->personanatural->primer_nombre . " " . $pastor->personanatural->primer_apellido . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('pastor.index');
        } else {
            flash("El pastor <strong>" . $pastor->personanatural->primer_nombre . " " . $pastor->personanatural->primer_apellido . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('pastor.index');
        }
        //       }
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
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        return view('feligresia.feligresia.pastores.create')
                        ->with('location', 'feligresia')
                        ->with('feligres', $feligres)
                        ->with('asociaciones', $asociaciones);
    }

}
