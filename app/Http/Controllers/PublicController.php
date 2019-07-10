<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anuncio;
use App\Historia;
use App\Mision;
use App\Vision;
use App\Valor;
use App\Pedidosoracion;
use App\Ministerioextra;
use App\Iglesia;
use App\Ciudad;

class PublicController extends Controller {

    public function anuncio($id) {
        $anuncio = Anuncio::find($id);
        if ($anuncio != null) {
            return view('anuncio')->with('n', $anuncio);
        } else {
            return redirect()->back();
        }
    }

    public function creencias() {
        return view('creencias');
    }

    public function institucional() {
        $h = Historia::where('actual', 'SI')->first();
        $m = Mision::where('actual', 'SI')->first();
        $v = Vision::where('actual', 'SI')->first();
        $val = Valor::all();
        return view('institucional')
                        ->with('h', $h)
                        ->with('m', $m)
                        ->with('v', $v)
                        ->with('val', $val);
    }

    public function hacerpedido(Request $request) {
        $p = new Pedidosoracion($request->all());
        $p->persona = strtoupper($p->persona);
        $p->pedido = strtoupper($p->pedido);
        $p->tipo = "PUBLICO";
        $p->estado = "CREADO";
        $titulo = $mensaje = "";
        if ($p->save()) {
            $titulo = "INFORMACIÓN";
            $mensaje = "Pedido realizado con éxito, para rastrear su petición use el ID: " . $p->id;
        } else {
            $titulo = "ATENCIÓN";
            $mensaje = "El pedido no pudo ser realizado.";
        }
        return view('response')->with('titulo', $titulo)
                        ->with('mensaje', $mensaje);
    }

    public function consultarpedido(Request $request) {
        $p = Pedidosoracion::find($request->id);
        $titulo = $mensaje = "";
        if ($p != null) {
            $titulo = "INFORMACIÓN";
            $persona = "";
            if ($p->persona == null) {
                $persona = $p->feligres->personanatural->primer_nombre . " " . $p->feligres->personanatural->primer_apellido;
            } else {
                $persona = $p->persona;
            }
            $mensaje = "Señor(a) " . $persona . " su pedido de oración se encuentra en estado: " . $p->estado;
        } else {
            $titulo = "ATENCIÓN";
            $mensaje = "El ID consultado no corresponde a ningún pedido registrado...";
        }
        return view('response')->with('titulo', $titulo)
                        ->with('mensaje', $mensaje);
    }

    public function minextraver($id) {
        $m = Ministerioextra::find($id);
        $m->multimediaministerials;
        $titulo = $mensaje = "";
        if ($m != null) {
            $titulo = "MULTIMEDIA, ACTIVIDAD Y RECURSOS MINISTERIALES";
            $mensaje = "<h1 class='card-inside-title'>DATOS DEL MINISTERIO</h1><div class='col-md-12'>"
                    . "<table class='table table-hover'><tbody><tr class='read'><td class='contact'><b>MINISTERIO</b></td>"
                    . "<td class='contact'><b>TIPO MINISTERIO</b></td></tr><tr class='read'><td class='contact'>" . $m->nombre . "</td>"
                    . "<td class='subject'>" . $m->tipoministerio->nombre . "</td></tr><tr class='read'>"
                    . "<td class='contact'><b>DESCRIPCIÓN</b></td><td class='contact'><b>CREACIÓN</b></td></tr><tr class='read'>"
                    . "<td class='contact'>" . $m->descripcion . "</td><td class='subject'>" . $m->created_at . "</td></tr>"
                    . "</tbody></table></div><h1 class='card-inside-title'>PRESENTACIÓN</h1><div class='col-md-12'>" . $m->presentacion . "</div>"
                    . "<h1 class='card-inside-title'>LISTADO DE RECURSOS DEL MINISTERIO</h1><div class='clearfix m-b-20'><div class='dd'><ul class='list-group'>";
            if (count($m->multimediaministerials) > 0) {
                foreach ($m->multimediaministerials as $r) {
                    $mensaje = $mensaje . "<li class='list-group list-group-item' data-id='" . $r->id . "><div class='dd-handle'>" . $r->nombre . " - " . $r->descripcion . "</div>";
                    if (count($r->multimediaministerialitems) > 0) {
                        $mensaje = $mensaje . "<ul class='list-group'>";
                        foreach ($r->multimediaministerialitems as $i) {
                            $mensaje = $mensaje . "<li class='list-group list-group-item' data-id='3'><div class='dd-handle'>"
                                    . "<a href='" . config('app.url') . "/docs/multimedia/" . $i->recurso . "' target='_blank'>" . $i->recurso . "</a></div></li>";
                        }
                        $mensaje = $mensaje . "</ul>";
                    }
                    $mensaje = $mensaje . "</li>";
                }
            }
            $mensaje = $mensaje . "</ul></div></div>";
        } else {
            $titulo = "ATENCIÓN";
            $mensaje = "El ministerio consultado no contiene información registrada...";
        }
        return view('response')->with('titulo', $titulo)
                        ->with('mensaje', $mensaje);
    }

    public function iglesia($id) {
        $c = Ciudad::find($id);
        $response = [
            'error' => 'NO',
            'mensaje' => ''
        ];
        if ($c != null) {
            $iglesias = $c->iglesias;
            if (count($iglesias) > 0) {
                foreach ($iglesias as $i) {
                    $i->iglesiamapa;
                }
                $response = [
                    'error' => 'NO',
                    'mensaje' => '',
                    'data' => $iglesias
                ];
            } else {
                $response = [
                    'error' => 'SI',
                    'mensaje' => 'La ciudad no posee iglesias.'
                ];
            }
        } else {
            $response = [
                'error' => 'SI',
                'mensaje' => 'La ciudad no pudo ser establecida.'
            ];
        }
        return json_encode($response);
    }

}
