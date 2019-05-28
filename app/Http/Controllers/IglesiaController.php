<?php

namespace App\Http\Controllers;

use App\Iglesia;
use App\Zona;
use App\Distrito;
use App\Ciudad;
use App\Pastor;
use App\Asociacion;
use App\Union;
use App\Auditoriafeligresia;
use App\Http\Requests\IglesiaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IglesiaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $iglesias = Iglesia::all();
        $iglesias->each(function($item) {
            $item->ciudad;
            $item->zona;
            $item->distrito;
        });
        return view('feligresia.estructura_eclesiastica.iglesias.list')
                        ->with('location', 'feligresia')
                        ->with('iglesias', $iglesias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $zonas = Zona::all()->pluck('nombre', 'id');
        $distritos = Distrito::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.iglesias.create')
                        ->with('location', 'feligresia')
                        ->with('ciudades', $ciudades)
                        ->with('zonas', $zonas)
                        ->with('distritos', $distritos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $iglesia = new Iglesia($request->all());
        foreach ($iglesia->attributesToArray() as $key => $value) {
            if ($key == 'sitioweb') {
                $iglesia->$key = $value;
            } else {
                $iglesia->$key = strtoupper($value);
            }
        }
        if ($iglesia->fundacion == "") {
            $iglesia->fundacion = null;
        }
        if ($iglesia->zona_id == "") {
            $iglesia->zona_id = null;
        }
        $result = $iglesia->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE IGLESIA. DATOS: ";
            foreach ($iglesia->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $iglesia->ciudad->nombre;
                } else if ($key == 'distrito_id') {
                    $str = $str . ", " . $key . ": " . $value . ", distrito:" . $iglesia->distrito->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La iglesia <strong>" . $iglesia->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('iglesia.index');
        } else {
            flash("La iglesia <strong>" . $iglesia->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('iglesia.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Iglesia  $iglesia
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $iglesia = Iglesia::find($id);
        $iglesia->ciudad;
        $iglesia->zona;
        $iglesia->distrito;
        return view('feligresia.estructura_eclesiastica.iglesias.show')
                        ->with('location', 'feligresia')
                        ->with('iglesia', $iglesia);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Iglesia  $iglesia
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $iglesia = Iglesia::find($id);
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $zonas = Zona::all()->pluck('nombre', 'id');
        $distritos = Distrito::all()->pluck('nombre', 'id');
        return view('feligresia.estructura_eclesiastica.iglesias.edit')
                        ->with('location', 'feligresia')
                        ->with('iglesia', $iglesia)
                        ->with('ciudades', $ciudades)
                        ->with('zonas', $zonas)
                        ->with('distritos', $distritos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Iglesia  $iglesia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $iglesia = Iglesia::find($id);
        $m = new Iglesia($iglesia->attributesToArray());
        foreach ($iglesia->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key == 'sitioweb') {
                    $iglesia->$key = $request->$key;
                } else {
                    $iglesia->$key = strtoupper($request->$key);
                }
            }
        }
        $result = $iglesia->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE IGLESIA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", ciudad:" . $m->ciudad->nombre;
                } elseif ($key == 'distrito_id') {
                    $str2 = $str2 . ", " . $key . ": " . $value . ", distrito:" . $m->distrito->nombre;
                } else {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
            }
            foreach ($iglesia->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $iglesia->ciudad->nombre;
                } else if ($key == 'distrito_id') {
                    $str = $str . ", " . $key . ": " . $value . ", distrito:" . $iglesia->distrito->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La iglesia <strong>" . $iglesia->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('iglesia.index');
        } else {
            flash("La iglesia <strong>" . $iglesia->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('iglesia.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Iglesia  $iglesia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $iglesia = Iglesia::find($id);
//        if (count($distrito->iglesias) > 0) {
//            flash("La iglesia <strong>" . $distrito->nombre . "</strong> no pudo ser eliminado porque tiene iglesias asociadas.")->warning();
//            return redirect()->route('iglesia.index');
//        } else {
        $result = $iglesia->delete();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE IGLESIA. DATOS ELIMINADOS: ";
            foreach ($iglesia->attributesToArray() as $key => $value) {
                if ($key == 'ciudad_id') {
                    $str = $str . ", " . $key . ": " . $value . ", ciudad:" . $iglesia->ciudad->nombre;
                } else if ($key == 'distrito_id') {
                    $str = $str . ", " . $key . ": " . $value . ", distrito:" . $iglesia->distrito->nombre;
                } else {
                    $str = $str . ", " . $key . ": " . $value;
                }
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La iglesia <strong>" . $iglesia->nombre . "</strong> fue eliminada de forma exitosa!")->success();
            return redirect()->route('iglesia.index');
        } else {
            flash("La iglesia <strong>" . $iglesia->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
            return redirect()->route('iglesia.index');
        }
//        }
    }

    public function directorioiglesia() {
        $iglesias = Iglesia::all();
        $ciudades = Ciudad::all()->pluck('nombre', 'id');
        $distritos = Distrito::all()->pluck('nombre', 'id');
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        $uniones = Union::all()->pluck('nombre', 'id');
        foreach ($iglesias as $i) {
            $p = Pastor::where('distrito_id', $i->distrito_id)->first();
            $pastor = null;
            if ($p != null) {
                $pastor = $p->personanatural->primer_nombre . " " . $p->personanatural->segundo_nombre . " " . $p->personanatural->primer_apellido . " " . $p->personanatural->segundo_apellido;
            }
            $i->pastor = $pastor;
        }
        return view('comunicaciones.directorio_iglesia.list')
                        ->with('location', 'comunicaciones')
                        ->with('iglesias', $iglesias)
                        ->with('distritos', $distritos)
                        ->with('uniones', $uniones)
                        ->with('asociaciones', $asociaciones)
                        ->with('ciudades', $ciudades);
    }

    /**
     * show all resource from a distrito,ciudad,asociacion o union.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function iglesias($id, $tipo) {
        if ($tipo == 'DISTRITO') {
            $distrito = Distrito::find($id);
            $iglesias = $distrito->iglesias;
        }
        if ($tipo == 'UNION') {
            $union = Union::find($id);
            $asoc = $union->asociacions;
            if (count($asoc) > 0) {
                $iglesias = null;
                foreach ($asoc as $aso) {
                    $dis = $aso->distritos;
                    if (count($dis) > 0) {
                        foreach ($dis as $d) {
                            $i = null;
                            $i = $d->iglesias;
                            $iglesias[] = $i;
                        }
                        if ($iglesias != null) {
                            $iglesiasf = null;
                            foreach ($iglesias as $igle) {
                                foreach ($igle as $value) {
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
                                    $obj["tipo"] = $value->tipo;
                                    $obj["ciudad"] = $value->ciudad->nombre;
                                    $obj["distrito"] = $value->distrito->nombre;
                                    if ($value->activa == 1) {
                                        $obj["estado"] = "ACTIVA";
                                    } else {
                                        $obj["estado"] = "INACTIVA";
                                    }
                                    $iglesiasf[] = $obj;
                                }
                            }
                        }
                    }
                }
                return json_encode($iglesiasf);
            } else {
                return "null";
            }
        }
        if ($tipo == 'ASOCIACION') {
            $asociacion = Asociacion::find($id);
            $dis = $asociacion->distritos;
            if (count($dis) > 0) {
                $iglesias = null;
                foreach ($dis as $d) {
                    $i = null;
                    $i = $d->iglesias;
                    $iglesias[] = $i;
                }
                if ($iglesias != null) {
                    $iglesiasf = null;
                    foreach ($iglesias as $igle) {
                        foreach ($igle as $value) {
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
                            $obj["tipo"] = $value->tipo;
                            $obj["ciudad"] = $value->ciudad->nombre;
                            $obj["distrito"] = $value->distrito->nombre;
                            if ($value->activa == 1) {
                                $obj["estado"] = "ACTIVA";
                            } else {
                                $obj["estado"] = "INACTIVA";
                            }
                            $iglesiasf[] = $obj;
                        }
                    }
                    return json_encode($iglesiasf);
                } else {
                    return "null";
                }
            } else {
                return "null";
            }
        }
        if ($tipo == 'CIUDAD') {
            $ciudad = Ciudad::find($id);
            $iglesias = $ciudad->iglesias;
        }
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
                $obj["tipo"] = $value->tipo;
                $obj["ciudad"] = $value->ciudad->nombre;
                $obj["distrito"] = $value->distrito->nombre;
                if ($value->activa == 1) {
                    $obj["estado"] = "ACTIVA";
                } else {
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
