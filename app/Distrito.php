<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'ubicacion', 'email', 'sitioweb', 'ciudad_id', 'zona_id', 'asociacion_id', 'created_at', 'updated_at'
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

    public function zona() {
        return $this->belongsTo('App\Zona');
    }

    public function iglesias() {
        return $this->hasMany('App\Iglesia');
    }
    
    public function pastors() {
        return $this->hasMany('App\Pastor');
    }
    
    public function listapredicacions() {
        return $this->hasMany('App\Periodo');
    }
    
    public function anuncios() {
        return $this->hasMany('App\Anuncio');
    }
}
