<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'ubicacion', 'email', 'sitioweb', 'ciudad_id', 'asociacion_id', 'created_at', 'updated_at'
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

    public function asociacion() {
        return $this->belongsTo('App\Asociacion');
    }

    public function distritos() {
        return $this->hasMany('App\Distrito');
    }

    public function iglesias() {
        return $this->hasMany('App\Iglesia');
    }

}
