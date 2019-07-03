<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anuncio;

class PublicController extends Controller {

    public function anuncio($id) {
        $anuncio = Anuncio::find($id);
        if ($anuncio != null) {
            return view('anuncio')->with('n', $anuncio);
        } else {
            return redirect()->back();
        }
    }

}
