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
        'id', 'aceptado_por', 'retiro_por', 'pastor_oficiante', 'estado_actual', 'fecha_bautismo', 'asociacion_origen', 'distrito_origen', 'iglesia_origen', 'asociacion_destino', 'distrito_destino', 'iglesia_destino', 'iglesia_id', 'personanatural_id', 'situacionfeligres_id', 'created_at', 'updated_at'
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

    public function experiencialabors() {
        return $this->hasMany('App\Experiencialabor');
    }

    public function conocimientos() {
        return $this->hasMany('App\Conocimiento');
    }

    public function solicitudtraslados() {
        return $this->hasMany('App\Solicitudtraslado');
    }

    public function miembrojuntas() {
        return $this->hasMany('App\Miembrojunta');
    }

    public function agendajuntapuntos() {
        return $this->hasMany('App\Agendajuntapunto');
    }
    
    public function disciplinas() {
        return $this->hasMany('App\Disciplina');
    }

    public function situacionfeligres() {
        return $this->belongsTo('App\Situacionfeligres');
    }

    public function historicosituacions() {
        return $this->hasMany('App\Historicosituacion');
    }

}
