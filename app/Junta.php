<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Junta extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'etiqueta', 'vigente', 'iglesia_id', 'pastor_id', 'periodo_id', 'created_at', 'updated_at'
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

    public function pastor() {
        return $this->belongsTo('App\Pastor');
    }

    public function periodo() {
        return $this->belongsTo('App\Periodo');
    }

    public function miembrojuntas() {
        return $this->hasMany('App\Miembrojunta');
    }

    public function actajuntas() {
        return $this->hasMany('App\Actajunta');
    }

    public function agendajuntas() {
        return $this->hasMany('App\Agendajunta');
    }
    
    public function reunionjuntas() {
        return $this->hasMany('App\Reunionjunta');
    }

}
