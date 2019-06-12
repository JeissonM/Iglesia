<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Contacto;
use App\Chatmensaje;
use App\Auditoriacomunicacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $chats = Chat::where('user_id', $u->id)->get();
        if (count($chats) > 0) {
            foreach ($chats as $item) {
                $item->name = $item->contacto->feligres->personanatural->primer_nombre . " " . $item->contacto->feligres->personanatural->segundo_nombre . " " . $item->contacto->feligres->personanatural->primer_apellido . " " . $item->contacto->feligres->personanatural->segundo_apellido;
                $item->igle = $item->contacto->feligres->iglesia->nombre;
                $item->ciu = $item->contacto->feligres->iglesia->ciudad->nombre;
                $item->dist = $item->contacto->feligres->iglesia->distrito->nombre;
                $item->asoci = $item->contacto->feligres->iglesia->distrito->asociacion->nombre;
            }
        }
        return view('comunicaciones.chat.chats.list')
                        ->with('location', 'comunicacion')
                        ->with('chats', $chats);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $mensaje = new Chatmensaje($request->all());
        $result = $mensaje->save();
        if ($result) {
            flash("El mensaje fue enviado de forma exitosa!")->success();
            return redirect()->route('chat.show', $request->contacto_id);
        } else {
            flash("El mensaje no pudo ser enviado. Error: " . $result)->warning();
            return redirect()->route('chat.show', $request->contacto_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $u = Auth::user();
        $exist = Chat::where([['user_id', $u->id], ['contacto_id', $id]])->first();
        if ($exist != null) {
            $exist->chatmensajes;
        } else {
            $exist = new Chat();
            $exist->user_id = $u->id;
            $exist->contacto_id = $id;
            $exist->save();
            $exist->chatmensajes;
        }
        $contacto = Contacto::find($id);
        $cont = $contacto->feligres->personanatural->primer_nombre . " " . $contacto->feligres->personanatural->segundo_nombre . " " . $contacto->feligres->personanatural->primer_apellido . " " . $contacto->feligres->personanatural->segundo_apellido;
        $usuario = $u->nombres . " " . $u->apellidos;
        return view('comunicaciones.chat.chats.create')
                        ->with('location', 'comunicacion')
                        ->with('contacto', $contacto)
                        ->with('cont', $cont)
                        ->with('chat', $exist)
                        ->with('usuario', $usuario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $chat = Chat::find($id);
        $mensajes = $chat->chatmensajes;
        return view('comunicaciones.chat.chats.mensajes')
                        ->with('location', 'comunicacion')
                        ->with('chat', $chat)
                        ->with('mensajes', $mensajes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat) {
        //
    }

}
