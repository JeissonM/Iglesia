<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iglesia extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'ubicacion', 'email', 'fundacion', 'activa', 'sitioweb', 'tipo', 'ciudad_id', 'zona_id', 'distrito_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function ciudad() {
        return $this->belongsTo('App\Ciudad');
    }

    public function zona() {
        return $this->belongsTo('App\Zona');
    }

    public function distrito() {
        return $this->belongsTo('App\Distrito');
    }
    
    public function pastors() {
        return $this->hasMany('App\Pastor');
    }
    
    public function feligres() {
        return $this->hasMany('App\Feligres');
    }
    
    public function juntas() {
        return $this->hasMany('App\Junta');
    }

}
