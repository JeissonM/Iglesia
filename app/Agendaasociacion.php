<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendaasociacion extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'documento', 'estado', 'asociacion_id', 'periodo_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function asociacion() {
        return $this->belongsTo('App\Asociacion');
    }

    public function periodo() {
        return $this->belongsTo('App\Periodo');
    }

}
