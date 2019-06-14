<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Contacto;
use App\Chatmensaje;
use App\User;
use App\Persona;
use App\Personanatural;
use App\Feligres;
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
        $chats = Chat::where('user_id', $u->id)->orWhere('user2_id', $u->id)->get();
        if (count($chats) > 0) {
            foreach ($chats as $item) {
                if ($item->user_id == $u->id) {
                    $item->name = $item->contacto->feligres->personanatural->primer_nombre . " " . $item->contacto->feligres->personanatural->segundo_nombre . " " . $item->contacto->feligres->personanatural->primer_apellido . " " . $item->contacto->feligres->personanatural->segundo_apellido;
                    $item->igle = $item->contacto->feligres->iglesia->nombre;
                    $item->ciu = $item->contacto->feligres->iglesia->ciudad->nombre;
                    $item->dist = $item->contacto->feligres->iglesia->distrito->nombre;
                    $item->asoci = $item->contacto->feligres->iglesia->distrito->asociacion->nombre;
                } else {
                    $user = User::find($item->user_id);
                    $persona = Persona::where('numero_documento', $user->identificacion)->first();
                    $personanatural = Personanatural::where('persona_id', $persona->id)->first();
                    $feligres = Feligres::where('personanatural_id', $personanatural->id)->first();
                    $item->name = $personanatural->primer_nombre . " " . $personanatural->segundo_nombre . " " . $personanatural->primer_apellido . " " . $personanatural->segundo_apellido;
                    $item->igle = $feligres->iglesia->nombre;
                    $item->ciu = $feligres->iglesia->ciudad->nombre;
                    $item->dist = $feligres->iglesia->distrito->nombre;
                    $item->asoci = $feligres->iglesia->distrito->asociacion->nombre;
                }
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
            return redirect()->route('chat.chatshow', ["NULL", $mensaje->chat_id]);
        } else {
            flash("El mensaje no pudo ser enviado. Error: " . $result)->warning();
            return redirect()->route('chat.chatshow', ["NULL", $mensaje->chat_id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($contacto_id, $chat_id) {
        $u = Auth::user();
        if ($contacto_id != "NULL") {
            $exist = Chat::where([['user_id', $u->id], ['contacto_id', $contacto_id]])->first();
            $contacto = Contacto::find($contacto_id);
            if ($exist != null) {
                $exist->chatmensajes;
            } else {
                $user = User::where('identificacion', $contacto->feligres->personanatural->persona->numero_documento)->first();
                $exist = new Chat();
                $exist->user_id = $u->id;
                $exist->contacto_id = $contacto_id;
                $exist->user2_id = $user->id;
                $exist->save();
                $exist->chatmensajes;
            }
            $cont = $contacto->feligres->personanatural->primer_nombre . " " . $contacto->feligres->personanatural->segundo_nombre . " " . $contacto->feligres->personanatural->primer_apellido . " " . $contacto->feligres->personanatural->segundo_apellido;
        } else {
            $exist = Chat::find($chat_id);
            $exist->chatmensajes;
            if ($exist->user_id == $u->id) {
                $contacto = Contacto::find($exist->contacto_id);
                $cont = $contacto->feligres->personanatural->primer_nombre . " " . $contacto->feligres->personanatural->segundo_nombre . " " . $contacto->feligres->personanatural->primer_apellido . " " . $contacto->feligres->personanatural->segundo_apellido;
            } else {
                $persona = Persona::where('numero_documento', $exist->user->identificacion)->first();
                $personanatural = Personanatural::where('persona_id', $persona->id)->first();
                $feligres = Feligres::where('personanatural_id', $personanatural->id)->first();
                $contacto = Contacto::find($exist->contacto_id);
                $cont = $personanatural->primer_nombre . " " . $personanatural->segundo_nombre . " " . $personanatural->primer_apellido . " " . $personanatural->segundo_apellido;
            }
        }
        $usuario = $u->nombres . " " . $u->apellidos;
        return view('comunicaciones.chat.chats.create')
                        ->with('location', 'comunicacion')
                        ->with('contacto', $contacto)
                        ->with('cont', $cont)
                        ->with('usuario', $usuario)
                        ->with('chat', $exist);
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
    public function destroy($id) {
        $mensaje = Chatmensaje::find($id);
        $contacto = $mensaje->chat->contacto_id;
        $result = $mensaje->delete();
        if ($result) {
            return redirect()->route('chat.show', $contacto);
        } else {
            flash("El mensaje no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('chat.index', $contacto);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroyChat($id) {
        $chat = Chat::find($id);
        $result = $chat->delete();
        if ($result) {
            return redirect()->route('chat.index');
        } else {
            flash("El chat no pudo ser eliminado. Error: " . $result)->error();
            return redirect()->route('chat.index');
        }
    }

}
