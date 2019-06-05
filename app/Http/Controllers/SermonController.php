<?php

namespace App\Http\Controllers;

use App\Sermon;
use App\Feligres;
use App\Pastor;
use App\Auditoriagestiondocumental;
use App\Http\Requests\SermonRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SermonController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $sermones = Sermon::all();
        if (count($sermones) > 0) {
            foreach ($sermones as $value) {
                if ($value->feligres_id != null) {
                    $value->nombre = $value->feligres->personanatural->primer_nombre . " " . $value->feligres->personanatural->segundo_nombre . " " . $value->feligres->personanatural->primer_apellido . " " . $value->feligres->personanatural->segundo_apellido;
                } else if ($value->pastor_id != null) {
                    $value->nombre = $value->pastor->personanatural->primer_nombre . " " . $value->pastor->personanatural->segundo_nombre . " " . $value->pastor->personanatural->primer_apellido . " " . $value->pastor->personanatural->segundo_apellido;
                } else {
                    $value->nombre = $value->otro;
                }
            }
        }
        return view('gestion_documental.sermon.list')
                        ->with('location', 'gestion-documental')
                        ->with('sermones', $sermones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $feligres = Feligres::all();
        $pastor = Pastor::all();
        $feligreses = null;
        $pastores = null;
        if (count($feligres) > 0) {
            foreach ($feligres as $value) {
                $feligreses[$value->id] = $value->personanatural->primer_nombre . " " . $value->personanatural->segundo_nombre . " " . $value->personanatural->primer_apellido . " " . $value->personanatural->segundo_apellido;
            }
        }
        if (count($pastor) > 0) {
            foreach ($pastor as $value) {
                $pastores[$value->id] = $value->personanatural->primer_nombre . " " . $value->personanatural->segundo_nombre . " " . $value->personanatural->primer_apellido . " " . $value->personanatural->segundo_apellido;
            }
        }
        return view('gestion_documental.sermon.create')
                        ->with('location', 'gestion-documental')
                        ->with('pastores', $pastores)
                        ->with('feligreses', $feligreses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $sermon = new Sermon($request->all());
        foreach ($sermon->attributesToArray() as $key => $value) {
            $sermon->$key = strtoupper($value);
        }
        if (isset($request->archivo)) {
            $file = $request->file("archivo");
            $hoy = getdate();
            $name = "Multimedia_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/multimedia/sermones/";
            $file->move($path, $name);
            $sermon->archivo = $name;
        } else {
            $sermon->archivo = "no";
        }
        $result = $sermon->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriagestiondocumental();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE SERMON. DATOS: ";
            foreach ($sermon->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El sermon <strong>" . $sermon->titulo . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('sermon.index');
        } else {
            flash("El sermon <strong>" . $sermon->titulo . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('sermon.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sermon  $sermon
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $sermon = Sermon::find($id);
        return view('gestion_documental.sermon.show')
                        ->with('location', 'gestion-documental')
                        ->with('sermon', $sermon);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sermon  $sermon
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $sermon = Sermon::find($id);
        return view('gestion_documental.sermon.edit')
                        ->with('location', 'gestion-documental')
                        ->with('sermon', $sermon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sermon  $sermon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $sermon = Sermon::find($id);
        $m = new Sermon($sermon->attributesToArray());
        foreach ($sermon->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $sermon->$key = strtoupper($request->$key);
            }
        }
        $result = $sermon->save();
        if ($result) {
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE SERMON. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($sermon->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El sermon <strong>" . $sermon->titulo . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('sermon.index');
        } else {
            flash("El sermon <strong>" . $sermon->titulo . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('sermon.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sermon  $sermon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $sermon = Sermon::find($id);
//        if (count($sermon->ministerioextras) > 0) {
//            flash("El tipo de ministerio <strong>" . $sermon->nombre . "</strong> no pudo ser eliminado porque tiene ministerios extras asociados.")->warning();
//            return redirect()->route('tipoministerio.index');
//        } else {
        $result = $sermon->delete();
        if ($result) {
            unlink(public_path() . "/multimedia/sermones/" . $sermon->archivo);
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE SERMON. DATOS ELIMINADOS: ";
            foreach ($sermon->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El sermon <strong>" . $sermon->titulo . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('sermon.index');
        } else {
            flash("El sermon <strong>" . $sermon->titulo . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('sermon.index');
        }
//        }
    }

}
