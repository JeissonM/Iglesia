<?php

namespace App\Http\Controllers;

use App\Categorialabor;
use App\Auditoriafeligresia;
use App\Http\Requests\CategorialaborRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CategorialaborController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categorias = Categorialabor::all();
        return view('feligresia.feligresia.categoria_labor.list')
                        ->with('location', 'feligresia')
                        ->with('categorias', $categorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feligresia.feligresia.categoria_labor.create')
                        ->with('location', 'feligresia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorialaborRequest $request) {
        $categoria = new Categorialabor($request->all());
        foreach ($categoria->attributesToArray() as $key => $value) {
            $categoria->$key = strtoupper($value);
        }
        $result = $categoria->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriafeligresia();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE CATEGORIA LABOR. DATOS: ";
            foreach ($categoria->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La categoría <strong>" . $categoria->nombre . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('categorialabor.index');
        } else {
            flash("La categoría <strong>" . $categoria->nombre . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('categorialabor.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categorialabor  $categorialabor
     * @return \Illuminate\Http\Response
     */
    public function show(Categorialabor $categorialabor) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categorialabor  $categorialabor
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $categoria = Categorialabor::find($id);
        return view('feligresia.feligresia.categoria_labor.edit')
                        ->with('location', 'feligresia')
                        ->with('categoria', $categoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categorialabor  $categorialabor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $categoria = Categorialabor::find($id);
        $m = new Categorialabor($categoria->attributesToArray());
        foreach ($categoria->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $categoria->$key = strtoupper($request->$key);
            }
        }
        $result = $categoria->save();
        if ($result) {
            $aud = new Auditoriafeligresia();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION CATEGORIA LABOR. DATOS NUEVOS: ";
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
            return redirect()->route('categorialabor.index');
        } else {
            flash("La categoría <strong>" . $categoria->nombre . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('categorialabor.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categorialabor  $categorialabor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $categoria = Categorialabor::find($id);
        if (count($categoria->labors) > 0) {
            flash("La categoria <strong>" . $categoria->nombre . "</strong> no pudo ser eliminada porque tiene labores asociados.")->warning();
            return redirect()->route('tipoministerio.index');
        } else {
            $result = $categoria->delete();
            if ($result) {
                $aud = new Auditoriafeligresia();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ELIMINAR";
                $str = "ELIMINACIÓN DE CATEGORIA LABOR. DATOS ELIMINADOS: ";
                foreach ($categoria->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("La categoría <strong>" . $categoria->nombre . "</strong> fue eliminado de forma exitosa!")->success();
                return redirect()->route('categorialabor.index');
            } else {
                flash("La categoría <strong>" . $categoria->nombre . "</strong> no pudo ser eliminado. Error: " . $result)->error();
                return redirect()->route('categorialabor.index');
            }
        }
    }

    /**
     * show all resource from a categorialabor.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function labores($id) {
        $categoria = Categorialabor::find($id);
        if ($categoria != null) {
            $labores = $categoria->labors;
            if (count($labores) > 0) {
                $laboresf = null;
                foreach ($labores as $value) {
                    $obj["id"] = $value->id;
                    $obj["value"] = $value->nombre;
                    $laboresf[] = $obj;
                }
                return json_encode($laboresf);
            } else {
                return "null";
            }
        } else {
            return "null";
        }
    }

}
