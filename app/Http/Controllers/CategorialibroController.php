<?php

namespace App\Http\Controllers;

use App\Categorialibro;
use App\Auditoriagestiondocumental;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategorialibroRequest;
use Illuminate\Http\Request;

class CategorialibroController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categorias = Categorialibro::all();
        return view('gestion_documental.editorial.categoria.list')
                        ->with('location', 'gestion-documental')
                        ->with('categorias', $categorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('gestion_documental.editorial.categoria.create')
                        ->with('location', 'gestion-documental');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorialibroRequest $request) {
        $categoria = new Categorialibro($request->all());
        foreach ($categoria->attributesToArray() as $key => $value) {
            $categoria->$key = strtoupper($value);
        }
        $result = $categoria->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriagestiondocumental();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CATEGORÍA DE LIBRO. DATOS: ";
            foreach ($categoria->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La categoría <strong>" . $categoria->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('categorialibro.index');
        } else {
            flash("La categoría <strong>" . $categoria->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('categorialibro.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categorialibro  $categorialibro
     * @return \Illuminate\Http\Response
     */
    public function show(Categorialibro $categorialibro) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categorialibro  $categorialibro
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $categoria = Categorialibro::find($id);
        return view('gestion_documental.editorial.categoria.edit')
                        ->with('location', 'gestion-documental')
                        ->with('categoria', $categoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categorialibro  $categorialibro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $categoria = Categorialibro::find($id);
        $m = new Categorialibro($categoria->attributesToArray());
        foreach ($categoria->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $categoria->$key = strtoupper($request->$key);
            }
        }
        $result = $categoria->save();
        if ($result) {
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE CATEGORÍA LIBRO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($categoria->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La categoría <strong>" . $categoria->nombre . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('categorialibro.index');
        } else {
            flash("La categoría <strong>" . $categoria->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('categorialibro.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categorialibro  $categorialibro
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $categoria = Categorialibro::find($id);
        if (count($categoria->libros) > 0) {
            flash("La categoría <strong>" . $categoria->nombre . "</strong> no pudo ser eliminado porque tiene libros asociados.")->warning();
            return redirect()->route('categorialibro.index');
        } else {
            $result = $categoria->delete();
            if ($result) {
                $aud = new Auditoriagestiondocumental();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE CATEGORIA LIBRO. DATOS ELIMINADOS: ";
                foreach ($categoria->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La categoría <strong>" . $categoria->nombre . "</strong> fue eliminada de forma exitosa!")->success();
                return redirect()->route('categorialibro.index');
            } else {
                flash("La categoría <strong>" . $categoria->nombre . "</strong> no pudo ser eliminada. Error: " . $result)->error();
                return redirect()->route('categorialibro.index');
            }
        }
    }

}
