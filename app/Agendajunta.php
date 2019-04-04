<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendajunta extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'fecha_reunion', 'junta_id', 'created_at', 'updated_at'
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

    public function agendajuntapuntos() {
        return $this->hasMany('App\Agendajuntapunto');
    }
    
    public function reunionjuntas() {
        return $this->hasMany('App\Reunionjunta');
    }

}
