<?php

namespace App\Http\Controllers;

use App\Libro;
use App\Categorialibro;
use App\Autor;
use App\Auditoriagestiondocumental;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LibroRequest;
use Illuminate\Http\Request;

class LibroController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $libros = Libro::all();
        if (count($libros) > 0) {
            foreach ($libros as $l) {
                $libros->autores = $l->autors;
            }
        }
        return view('gestion_documental.editorial.libro.list')
                        ->with('location', 'gestion-documental')
                        ->with('libros', $libros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categorias = Categorialibro::all()->pluck('nombre', 'id');
        return view('gestion_documental.editorial.libro.create')
                        ->with('location', 'gestion-documental')
                        ->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LibroRequest $request) {
        $libro = new Libro($request->all());
        foreach ($libro->attributesToArray() as $key => $value) {
            $libro->$key = strtoupper($value);
        }
        if (isset($request->documento)) {
            $file = $request->file("documento");
            $hoy = getdate();
            $name = "Documento_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/libros/";
            $file->move($path, $name);
            $libro->documento = $name;
        } else {
            $libro->documento = "no";
        }
        if (isset($request->imagen)) {
            $file = $request->file("imagen");
            $hoy = getdate();
            $name = "Imagen_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
            $path = public_path() . "/docs/img_libros/";
            $file->move($path, $name);
            $libro->imagen = $name;
        } else {
            $libro->imagen = "no";
        }
        $result = $libro->save();
        if ($result) {
            $autor = new Autor();
            $autor->autor = strtoupper($request->autor);
            $autor->libro_id = $libro->id;
            $autor->save();
            $u = Auth::user();
            $aud = new Auditoriagestiondocumental();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "INSERTAR";
            $str = "CREACIÓN DE LIBRO. DATOS: ";
            foreach ($libro->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El libro <strong>" . $libro->titulo . "</strong> fue almacenado de forma exitosa!")->success();
            return redirect()->route('libro.index');
        } else {
            flash("El libro <strong>" . $libro->titulo . "</strong> no pudo ser almacenado. Error: " . $result)->error();
            return redirect()->route('libro.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $libro = Libro::find($id);
        $libro->autores = $libro->autors;
        return view('gestion_documental.editorial.libro.show')
                        ->with('location', 'gestion-documental')
                        ->with('libro', $libro);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $libro = Libro::find($id);
        $categorias = Categorialibro::all()->pluck('nombre', 'id');
        $autor = Autor::where('libro_id', $libro->id)->first();
        return view('gestion_documental.editorial.libro.edit')
                        ->with('location', 'gestion-documental')
                        ->with('libro', $libro)
                        ->with('autor', $autor)
                        ->with('categorias', $categorias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $libro = Libro::find($id);
        $m = new Libro($libro->attributesToArray());
        foreach ($libro->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $libro->$key = strtoupper($request->$key);
            }
        }
        $result = $libro->save();
        if ($result) {
            $autor = Autor::where('libro_id', $libro->id)->first();
            $autor->autor = strtoupper($request->autor);
            $autor->save();
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ACTUALIZAR DATOS";
            $str = "EDICION DE LIBRO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($libro->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("El libro <strong>" . $libro->titulo . "</strong> fue modificado de forma exitosa!")->success();
            return redirect()->route('libro.index');
        } else {
            flash("El libro <strong>" . $libro->titulo . "</strong> no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('libro.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $libro = Libro::find($id);
//        if (count($libro->itinerariodetalles) > 0) {
//            flash("El evento <strong>" . $libro->titulo . "</strong> no pudo ser eliminado porque tiene detalles asociados.")->warning();
//            return redirect()->route('itinerario.index');
//        } else {
        $result = $libro->delete();
        if ($result) {
            $aud = new Auditoriagestiondocumental();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ELIMINAR";
            $str = "ELIMINACIÓN DE LIBRO DATOS ELIMINADOS: ";
            foreach ($libro->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("El libro <strong>" . $libro->titulo . "</strong> fue eliminado de forma exitosa!")->success();
            return redirect()->route('libro.index');
        } else {
            flash("El libro <strong>" . $libro->titulo . "</strong> no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('libro.index');
        }
        //}
    }

    public function edit_doc($id) {
        $libro = Libro::find($id);
        return view('gestion_documental.editorial.libro.documento')
                        ->with('location', 'gestion-documental')
                        ->with('libro', $libro);
    }

    public function edit_img($id) {
        $libro = Libro::find($id);
        return view('gestion_documental.editorial.libro.imagen')
                        ->with('location', 'gestion-documental')
                        ->with('libro', $libro);
    }

    public function documento(Request $request) {
        $libro = Libro::find($request->id);
        if (isset($request->documento)) {
            if (unlink(public_path() . "/docs/libros/" . $libro->documento)) {
                $file = $request->file("documento");
                $hoy = getdate();
                $name = "Documento_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/libros/";
                $file->move($path, $name);
                $libro->documento = $name;
            } else {
                flash("El documento no pudo ser modificado. Error: ")->error();
                return redirect()->route('libro.edit', $request->id);
            }
        } else {
            flash("El documento no pudo ser modificado, porque no se encontro ningun documento. Error: ")->error();
            return redirect()->route('libro.edit', $request->id);
        }
        $result = $libro->save();
        if ($result) {
            flash("El documento fue modificado de forma exitosa!")->success();
            return redirect()->route('libro.editdoc', $request->id);
        } else {
            flash("El documento no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('libro.edit', $request->id);
        }
    }

    public function imagen(Request $request) {
        $libro = Libro::find($request->id);
        if (isset($request->imagen)) {
            if (unlink(public_path() . "/docs/img_libros/" . $libro->imagen)) {
                $file = $request->file("imagen");
                $hoy = getdate();
                $name = "Imagen_" . $hoy["year"] . $hoy["mon"] . $hoy["mday"] . $hoy["hours"] . $hoy["minutes"] . $hoy["seconds"] . "." . $file->getClientOriginalExtension();
                $path = public_path() . "/docs/img_libros/";
                $file->move($path, $name);
                $libro->imagen = $name;
            } else {
                flash("El documento no pudo ser modificado. Error: ")->error();
                return redirect()->route('libro.editimg', $request->id);
            }
        } else {
            flash("El documento no pudo ser modificado, porque no se encontro ningun documento. Error: ")->error();
            return redirect()->route('libro.editimg', $request->id);
        }
        $result = $libro->save();
        if ($result) {
            flash("El documento fue modificado de forma exitosa!")->success();
            return redirect()->route('libro.editimg', $request->id);
        } else {
            flash("El documento no pudo ser modificado. Error: " . $result)->error();
            return redirect()->route('libro.editimg', $request->id);
        }
    }

}
