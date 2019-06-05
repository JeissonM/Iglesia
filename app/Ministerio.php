<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ministerio extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function cargogenerals() {
        return $this->hasMany('App\Cargogeneral');
    }
    
    public function recursosministerials() {
        return $this->hasMany('App\Recursosministerial');
    }
    
    public function multimediaministerials() {
        return $this->hasMany('App\Multimediaministerial');
    }

}
