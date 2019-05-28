<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listapredicacion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'periodoespecifico', 'distrito_id', 'periodo_id', 'created_at', 'updated_at' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];
    
    public function periodo() {
        return $this->belongsTo('App\Periodo');
    }

    public function distrito() {
        return $this->belongsTo('App\Distrito');
    }
    
    public function listapredicacionfechas() {
        return $this->hasMany('App\Listapredicacionfecha');
    }
}
