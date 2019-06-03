<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tipo', 'titulo', 'contenido', 'autor', 'imagen', 'estado', 'iglesia_id', 'distrito_id', 'asociacion_id', 'feligres_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function iglesia() {
        return $this->belongsTo('App\Iglesia');
    }

    public function distrito() {
        return $this->belongsTo('App\Distrito');
    }

    public function asociacion() {
        return $this->belongsTo('App\Asociacion');
    }

    public function feligres() {
        return $this->belongsTo('App\Feligres');
    }

}
