<?php

namespace App\Http\Controllers;

use App\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AnuncioRequest;
use App\Auditoriacomunicacion;
use App\Asociacion;
use App\Persona;

class AnuncioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $anuncios = Anuncio::all();
        return view('comunicaciones.anuncios.list')
                        ->with('location', 'comunicacion')
                        ->with('anuncios', $anuncios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $asociaciones = Asociacion::all()->pluck('nombre', 'id');
        $u = Auth::user();
        $feligreses = null;
        $ps = Persona::where('numero_documento', $u->identificacion)->get();
        if (count($ps) > 0) {
            foreach ($ps as $p) {
                $pns = $p->personanaturals;
                if (count($pns) > 0) {
                    foreach ($pns as $pn) {
                        $feligres = $pn->feligres;
                        if (count($feligres) > 0) {
                            foreach ($feligres as $f) {
                                $feligreses[$f->id] = $pn->primer_nombre . " " . $pn->segundo_nombre . " " . $pn->primer_apellido . " " . $pn->segundo_apellido;
                            }
                        }
                    }
                }
            }
        }
        return view('comunicaciones.anuncios.create')
                        ->with('location', 'comunicacion')
                        ->with('asociaciones', $asociaciones)
                        ->with('feligreses', $feligreses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnuncioRequest $request) {
        $anuncio = new Anuncio($request->all());
        foreach ($anuncio->attributesToArray() as $key => $value) {
            if ($key != 'contenido') {
                $anuncio->$key = strtoupper($value);
            } else {
                $anuncio->$key = $value;
            }
        }
        if (isset($request->imagen)) {
            $file = $request->file("imagen");
            $hoy = getdate();
            $name = "Anuncio_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/anuncios/";
            $file->move($path, $name);
            $anuncio->imagen = $name;
        } else {
            $anuncio->imagen = "NO";
        }
        $u = Auth::user();
        $anuncio->autor = $u->nombres . " " . $u->apellidos;
        $anuncio->estado = 'VIGENTE';
        if ($anuncio->asociacion_id == '') {
            $anuncio->asociacion_id = null;
        }
        if ($anuncio->distrito_id == '') {
            $anuncio->distrito_id = null;
        }
        if ($anuncio->iglesia_id == '') {
            $anuncio->iglesia_id = null;
        }
        $result = $anuncio->save();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE ANUNCIO. DATOS: ";
            foreach ($anuncio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El anuncio fue almacenado de forma exitosa!")->success();
            return redirect()->route('anuncios.index');
        } else {
            flash("El anuncio no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('anuncios.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Anuncio  $anuncio
     * @return \Illuminate\Http\Response
     */
    public function show(Anuncio $anuncio) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Anuncio  $anuncio
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $anuncio = Anuncio::find($id);
        return view('comunicaciones.anuncios.edit')
                        ->with('location', 'comunicacion')
                        ->with('a', $anuncio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Anuncio  $anuncio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $anuncio = Anuncio::find($id);
        $m = new Anuncio($anuncio->attributesToArray());
        foreach ($anuncio->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key != 'contenido') {
                    $anuncio->$key = strtoupper($request->$key);
                } else {
                    $anuncio->$key = $request->$key;
                }
            }
        }
        $result = $anuncio->save();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE ANUNCIO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($anuncio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El anuncio fue modificado de forma exitosa!")->success();
            return redirect()->route('anuncios.index');
        } else {
            flash("El anuncio no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('anuncios.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Anuncio  $anuncio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $anuncio = Anuncio::find($id);
        $result = $anuncio->delete();
        if ($result) {
            $aud = new Auditoriacomunicacion();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE ANUNCIO DATOS ELIMINADOS: ";
            foreach ($anuncio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            unlink(public_path() . "/docs/anuncios/" . $anuncio->imagen);
            flash("El anuncio fue eliminado de forma exitosa!")->success();
            return redirect()->route('anuncios.index');
        } else {
            flash("El anuncio no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('anuncios.index');
        }
    }

    public function estado($id) {
        $anuncio = Anuncio::find($id);
        if ($anuncio->estado == 'VIGENTE') {
            $anuncio->estado = "VENCIDO";
        } else {
            $anuncio->estado = "VIGENTE";
        }
        $result = $anuncio->save();
        if ($result) {
            flash("El estado del anuncio fue modificado de forma exitosa!")->success();
            return redirect()->route('anuncios.index', $id);
        } else {
            flash("El estado del anuncio no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('anuncios.index', $id);
        }
    }

}
