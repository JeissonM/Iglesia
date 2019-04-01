<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feligres extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'aceptado_por', 'retiro_por', 'pastor_oficiante', 'estado_actual', 'fecha_bautismo', 'asociacion_origen', 'distrito_origen', 'iglesia_origen', 'asociacion_destino', 'distrito_destino', 'iglesia_destino', 'iglesia_id', 'personanatural_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function personanatural() {
        return $this->belongsTo('App\Personanatural');
    }

    public function iglesia() {
        return $this->belongsTo('App\Iglesia');
    }

}
