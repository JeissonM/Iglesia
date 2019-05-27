<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerariodetalle extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'orden', 'descripcion', 'horainicial', 'horafinal', 'itinerario_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function itinerario() {
        return $this->belongsTo('App\Itinerario');
    }

}
