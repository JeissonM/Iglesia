<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitudtraslado extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tiposolicitud', 'fechasolicitud', 'observacion', 'estado', 'iglesia_origen', 'iglesia_destino', 'acta_origen', 'acta_destino', 'feligres_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function feligres() {
        return $this->belongsTo('App\Feligres');
    }

}
