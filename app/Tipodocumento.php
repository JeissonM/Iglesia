<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipodocumento extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'descripcion', 'abreviatura', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];
    
    public function personas() {
        return $this->hasMany('App\Persona');
    }

}
