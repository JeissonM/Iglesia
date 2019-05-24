<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'descripcion', 'fechainicio', 'fechafin', 'feligres_id', 'reunionjunta_id', 'periodo_id', 'created_at', 'updated_at'
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

    public function reunionjunta() {
        return $this->belongsTo('App\Reunionjunta');
    }

    public function periodo() {
        return $this->belongsTo('App\Periodo');
    }

}
