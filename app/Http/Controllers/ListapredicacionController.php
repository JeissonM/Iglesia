<?php

namespace App\Http\Controllers;

use App\Listapredicacion;
use Illuminate\Http\Request;
use App\Listapredicacionfecha;
use App\Lppredicadoriglesia;
use Illuminate\Support\Facades\Auth;
use App\Feligres;
use App\Persona;
use App\Personanatural;
use App\Periodo;
use App\Distrito;
use App\Auditoriagestiondocumental;

class ListapredicacionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $p = Persona::where('numero_documento', $u->identificacion)->first();
        if ($p !== null) {
            $pn = Personanatural::where('persona_id', $p->id)->first();
            if ($pn !== null) {
                $f = Feligres::where([['personanatural_id', $pn->id], ['estado_actual', 'ACTIVO']])->first();
                if ($f !== null) {
                    $listas = Listapredicacion::where('distrito_id', $f->iglesia->distrito_id)->get();
                    return view('gestion_documental.lista_predicacion.list')
                                    ->with('location', 'gestion-documental')
                                    ->with('f', $f)
                                    ->with('listas', $listas);
                } else {
                    flash('Usted no se encuentra ACTIVO como feligrés, no puede acceder a esta función.')->warning();
                    return redirect()->route('admin.gestiondocumental');
                }
            } else {
                flash('Usted no se encuentra registrado como feligrés, no puede acceder a esta función.')->warning();
                return redirect()->route('admin.gestiondocumental');
            }
        } else {
            flash('Usted no se encuentra registrado como feligrés, no puede acceder a esta función.')->warning();
            return redirect()->route('admin.gestiondocumental');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $per = Periodo::all()->sortByDesc('id');
        $periodos = null;
        foreach ($per as $pe) {
            $periodos[$pe->id] = $pe->etiqueta . " - " . $pe->fechainicio . " - " . $pe->fechafin;
        }
        $distrito = Distrito::find($id);
        return view('gestion_documental.lista_predicacion.create')
                        ->with('location', 'gestion-documental')
                        ->with('periodos', $periodos)
                        ->with('distrito', $distrito);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $lista = new Listapredicacion($request->all());
        foreach ($lista->attributesToArray() as $key => $value) {
            $lista->$key = strtoupper($value);
        }
        $result = $lista->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriagestiondocumental();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE LISTA DE PREDICACIÓN. DATOS: ";
            foreach ($lista->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La lista fue almacenada de forma exitosa!")->success();
            return redirect()->route('listapredicacion.index');
        } else {
            flash("La lista no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('listapredicacion.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Listapredicacion  $listapredicacion
     * @return \Illuminate\Http\Response
     */
    public function show(Listapredicacion $listapredicacion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Listapredicacion  $listapredicacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $lista = Listapredicacion::find($id);
        $distrito = $lista->distrito;
        $tabla = "";
        $thead = "<thead><tr><th>FECHA</th>";
        $total = count($distrito->iglesias) + 1;
        foreach ($distrito->iglesias as $i) {
            $thead = $thead . "<th>" . $i->nombre . "</th>";
        }
        $thead = $thead . "<th id='quitar'>QUITAR</th></tr></thead>";
        $tbody = "";
        $fechas = $lista->listapredicacionfechas;
        if (count($fechas) > 0) {
            foreach ($fechas as $f) {
                $tbody = $tbody . "<tr><td>" . $f->fecha . " (" . $f->diasemana . ")</td>";
                $predicadores = $f->lppredicadoriglesias;
                if (count($predicadores) > 0) {
                    foreach ($predicadores as $p) {
                        if ($p->feligres != null) {
                            $tbody = $tbody . "<td>" . $p->feligres->personanatural->primer_nombre . " " . $p->feligres->personanatural->primer_apellido . "</td>";
                        } else {
                            $tbody = $tbody . "<td></td>";
                        }
                    }
                    $tbody = $tbody . "<td id='quitar'><a href='" . config('app.url') . "/gestiondocumental/listapredicacion/" . $id . "/crear/lista/items/" . $f->id . "/delete' style='cursor:pointer'><i class='material-icons'>delete</i></a></td></tr>";
                } else {
                    $tbody = $tbody . "</tr>";
                }
            }
            $tbody = $tbody . "</tbody>";
            $tabla = $thead . $tbody;
        } else {
            $tabla = $tabla . "<thead><tr><th>FECHA</th></tr></thead><tbody><tr><td>No hay predicadores para esta lista</td></tr></tbody>";
        }
        return view('gestion_documental.lista_predicacion.configurar')
                        ->with('location', 'gestion-documental')
                        ->with('lista', $lista)
                        ->with('distrito', $distrito)
                        ->with('tabla', $tabla)
                        ->with('index', $total);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Listapredicacion  $listapredicacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listapredicacion $listapredicacion) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Listapredicacion  $listapredicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $lista = Listapredicacion::find($id);
        if (count($lista->listapredicacionfechas) > 0) {
            flash("La lista no pudo ser eliminada porque tiene predicadores asociados.")->warning();
            return redirect()->route('listapredicacion.index');
        } else {
            $result = $lista->delete();
            if ($result) {
                $aud = new Auditoriagestiondocumental();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE LISTA DE PREDICACIÓN. DATOS ELIMINADOS: ";
                foreach ($lista->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La lista fue eliminada de forma exitosa!")->success();
                return redirect()->route('listapredicacion.index');
            } else {
                flash("La lista no pudo ser eliminada. Error: " . $result)->error();
                return redirect()->route('listapredicacion.index');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Listapredicacion  $listapredicacion
     * @return \Illuminate\Http\Response
     */
    public function delete2($id, $idf) {
        $lista = Listapredicacionfecha::find($idf);
        if (count($lista->lppredicadoriglesias) > 0) {
            foreach ($lista->lppredicadoriglesias as $i) {
                $i->delete();
            }
        }
        $result = $lista->delete();
        if ($result) {
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE DATOS DE LISTA DE PREDICACIÓN. DATOS ELIMINADOS: ";
            foreach ($lista->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El registro fue eliminado de forma exitosa!")->success();
            return redirect()->route('listapredicacion.edit', $id);
        } else {
            flash("El registro no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('listapredicacion.edit', $id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Listapredicacion  $listapredicacion
     * @return \Illuminate\Http\Response
     */
    public function create2($id) {
        $lista = Listapredicacion::find($id);
        $distrito = $lista->distrito;
        $iglesias = $distrito->iglesias;
        $feligreses = null;
        if (count($iglesias) > 0) {
            foreach ($iglesias as $i) {
                $fel = $i->feligres;
                if (count($fel) > 0) {
                    foreach ($fel as $f) {
                        $feligreses[$f->id] = $f->personanatural->primer_nombre . " " . $f->personanatural->segundo_nombre . " " . $f->personanatural->primer_apellido . " " . $f->personanatural->segundo_apellido;
                    }
                }
            }
            if (count($feligreses) > 0) {
                return view('gestion_documental.lista_predicacion.create2')
                                ->with('location', 'gestion-documental')
                                ->with('lista', $lista)
                                ->with('distrito', $distrito)
                                ->with('iglesias', $iglesias)
                                ->with('feligreses', $feligreses);
            } else {
                flash("Su distrito no tiene feligreses registrados")->error();
                return redirect()->route('listapredicacion.edit', $id);
            }
        } else {
            flash("Su distrito no tiene iglesias registradas")->error();
            return redirect()->route('listapredicacion.edit', $id);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request) {
        $lista = new Listapredicacionfecha($request->all());
        $result = $lista->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriagestiondocumental();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE LISTA DE PREDICACIÓN - REGISTROS DE LISTA. DATOS: ";
            foreach ($lista->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            foreach ($request->iglesia as $key => $i) {
                $item = new Lppredicadoriglesia();
                $item->iglesia_id = $i;
                $item->listapredicacionfecha_id = $lista->id;
                if ($request->feligres[$key] == "SIN") {
                    $item->feligres_id = null;
                } else {
                    $item->feligres_id = $request->feligres[$key];
                }
                $item->save();
            }
            flash("El registro fue almacenado de forma exitosa!")->success();
            return redirect()->route('listapredicacion.edit', $request->listapredicacion_id);
        } else {
            flash("El registro no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('listapredicacion.edit', $request->listapredicacion_id);
        }
    }

}
