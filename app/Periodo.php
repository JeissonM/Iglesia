<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'etiqueta', 'fechainicio', 'fechafin', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function juntas() {
        return $this->hasMany('App\Junta');
    }

    public function disciplinas() {
        return $this->hasMany('App\Disciplina');
    }

    public function itinerarios() {
        return $this->hasMany('App\Itinerario');
    }

    public function agendaasociacions() {
        return $this->hasMany('App\Agendaasociacion');
    }

    
    public function listapredicacions() {
        return $this->hasMany('App\Periodo');
    }
}
