<?php

namespace App\Http\Controllers;

use App\Iasd;
use App\Pais;
use App\Ciudad;
use App\Auditoriafeligresia;
use App\Http\Requests\IasdRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IasdController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $iasds = Iasd::all();
        return view('feligresia.estructura_eclesiastica.iasds.list')
                        ->with('location', 'feligresia')
                        ->with('iasds', $iasds);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $paises = Pais::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.iasds.create')
                        ->with('location', 'feligresia')
                        ->with('paises', $paises);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IasdRequest $request) {
        if ($request->actual == "1") {
            $iasd = count(Iasd::where('actual', 1)->get());
            if ($iasd > 0) {
                flash("Ya existe una conferencia general definida como ACTUAL y no pueden existir dos con dicho estado. Debe modificar la conferencia definida como ACTUAL a su estado NO ACTUAL para continuar.")->warning();
                return redirect()->route('iasd.create');
            }
        }
        $iasd = new Iasd($request->all());
        foreach ($iasd->attributesToArray() as $key => $value) {
            if ($key == 'sitioweb') {
                $iasd->$key = $value;
            } else {
                $iasd->$key = strtoupper($value);
            }
        }
        if (isset($request->ciudad_id)) {
            $c = Ciudad::find($request->ciudad_id);
            $ubicacion = "NO DEFINIDA";
            if ($c != null) {
                $c->estado->pais;
                if (isset($request->direccion)) {
                    $ubicacion = strtoupper($request->direccion) . " - " . $c->nombre . " - " . $c->estado->nombre . " - " . $c->estado->pais->nombre;
                } else {
                    $ubicacion = $c->nombre . " - " . $c->estado->nombre . " - " . $c->estado->pais->nombre;
                }
            }
            $iasd->ubicacion = $ubicacion;
        } else {
            $iasd->ubicacion = "NO DEFINIDA";
        }
        $result = $iasd->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CONFERENCIA GENERAL. DATOS: ";
            foreach ($iasd->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La conferencia general <strong>" . $iasd->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('iasd.index');
        } else {
            flash("La conferencia general <strong>" . $iasd->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('iasd.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Iasd  $iasd
     * @return \Illuminate\Http\Response
     */
    public function show(Iasd $iasd) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Iasd  $iasd
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $iasd = Iasd::find($id);
        return view('feligresia.estructura_eclesiastica.iasds.edit')
                        ->with('location', 'feligresia')
                        ->with('iasd', $iasd);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Iasd  $iasd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $bandera = false;
        if ($request->actual == "1") {
            $iasd = Iasd::where('actual', 1)->first();
            if ($iasd != null) {
                if ($iasd->id == $id) {
                    $bandera = false;
                } else {
                    $iasd->actual = 0;
                    $iasd->save();
                    $bandera = true;
                }
            }
        }
        $iasd = Iasd::find($id);
        $m = new Iasd($iasd->attributesToArray());
        foreach ($iasd->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key == 'sitioweb') {
                    $iasd->$key = $request->$key;
                } else {
                    $iasd->$key = strtoupper($request->$key);
                }
            }
        }
        $result = $iasd->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE IASD. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($iasd->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            if ($bandera == true) {
                flash("La conferencia <strong>" . $iasd->nombre . "</strong> fue modificada de forma exitosa!, Ya existia una conferencia general definida como ACTUAL la cual fue modificada. ")->success();
                return redirect()->route('iasd.index');
            } else {
                flash("La conferencia <strong>" . $iasd->nombre . "</strong> fue modificada de forma exitosa!")->success();
                return redirect()->route('iasd.index');
            }
        } else {
            flash("La conferencia <strong>" . $iasd->nombre . "</strong> no pudo ser modificada. Error: " . $result)->error();
            return redirect()->route('iasd.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Iasd  $iasd
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $iasd = Iasd::find($id);
        $result = $iasd->delete();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE IASD. DATOS ELIMINADOS: ";
            foreach ($iasd->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La conferencia <strong>" . $iasd->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('iasd.index');
        } else {
            flash("La conferencia <strong>" . $iasd->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('iasd.index');
        }
    }

}
