<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reunionjunta extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'fecha', 'asistentes', 'conlusiones', 'junta_id', 'agendajunta_id', 'actajunta_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function junta() {
        return $this->belongsTo('App\Junta');
    }

    public function agendajunta() {
        return $this->belongsTo('App\Agendajunta');
    }

    public function actajunta() {
        return $this->belongsTo('App\Actajunta');
    }
    
    public function disciplinas() {
        return $this->hasMany('App\Disciplina');
    }

}
