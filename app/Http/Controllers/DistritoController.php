<?php

namespace App\Http\Controllers;

use App\Distrito;
use Illuminate\Http\Request;
use App\Asociacion;
use App\Zona;
use App\Ciudad;
use App\Pastor;
use App\Http\Requests\DistritoRequest;
use App\Auditoriafeligresia;
use Illuminate\Support\Facades\Auth;

class DistritoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $distritos = Distrito::all();
        $distritos->each(function($item) {
            $item->ciudad;
            $item->zona;
            $item->asociacion;
        });
        return view('feligresia.estructura_eclesiastica.distritos.list')
                        ->with('location', 'feligresia')
                        ->with('distritos', $distritos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $zonas = Zona::all()->pluck('nombre', 'id');
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.distritos.create')
                        ->with('location', 'feligresia')
                        ->with('ciudades', $ciudades)
                        ->with('zonas', $zonas)
                        ->with('asociaciones', $asociaciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistritoRequest $request) {
        $distrito = new Distrito($request->all());
        foreach ($distrito->attributesToArray() as $key => $value) {
            $distrito->$key = strtoupper($value);
        }
        $result = $distrito->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE DISTRITOS. DATOS: ";
            foreach ($distrito->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El distrito <strong>" . $distrito->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('distrito.index');
        } else {
            flash("El distrito <strong>" . $distrito->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('distrito.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Distrito  $distrito
     * @return \Illuminate\Http\Response
     */
    public function show(Distrito $distrito) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Distrito  $distrito
     * @return \Illuminate\Http\Response
     */
    public function edit(Distrito $distrito) {
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $zonas = Zona::all()->pluck('nombre', 'id');
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.distritos.edit')
                        ->with('location', 'feligresia')
                        ->with('distrito', $distrito)
                        ->with('ciudades', $ciudades)
                        ->with('zonas', $zonas)
                        ->with('asociaciones', $asociaciones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Distrito  $distrito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distrito $distrito) {
        $m = new Distrito($distrito->attributesToArray());
        foreach ($distrito->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $distrito->$key = strtoupper($request->$key);
            }
        }
        $result = $distrito->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE DISTRITO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($distrito->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El distrito <strong>" . $distrito->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('distrito.index');
        } else {
            flash("El distrito <strong>" . $distrito->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('distrito.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Distrito  $distrito
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $distrito = Distrito::find($id);
        if (count($distrito->iglesias) > 0) {
            flash("El distrito <strong>" . $distrito->nombre . "</strong> no pudo ser eliminado porque tiene iglesias asociadas.")->warning();
            return redirect()->route('distrito.index');
        } else {
            $result = $distrito->delete();
            if ($result) {
                $aud = new Auditoriafeligresia();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE DISTRITO. DATOS ELIMINADOS: ";
                foreach ($distrito->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El distrito <strong>" . $distrito->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('distrito.index');
            } else {
                flash("El distrito <strong>" . $distrito->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('distrito.index');
            }
        }
    }

    /**
     * show all resource from a distrito.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function iglesias($id) {
        $distrito = Distrito::find($id);
        $iglesias = $distrito->iglesias;
        if (count($iglesias) > 0) {
            $iglesiasf = null;
            foreach ($iglesias as $value) {
                $p = Pastor::where('distrito_id', $value->distrito_id)->first();
                $pastor = null;
                if ($p != null) {
                    $pastor = $p->personanatural->primer_nombre . " " . $p->personanatural->segundo_nombre . " " . $p->personanatural->primer_apellido . " " . $p->personanatural->segundo_apellido;
                }
                $obj["pastor"] = $pastor;
                $obj["id"] = $value->id;
                $obj["value"] = $value->nombre;
                $obj["sitio"] = $value->sitioweb;
                $obj["correo"] = $value->email;
                $obj["ciudad"] = $value->ciudad->nombre;
                $obj["distrito"] = $value->distrito->nombre;
                if($value->activa == 1){
                     $obj["estado"] = "ACTIVA";
                }else{
                    $obj["estado"] = "INACTIVA";
                }
                $iglesiasf[] = $obj;
            }
            return json_encode($iglesiasf);
        } else {
            return "null";
        }
    }

}
