<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asociacion extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'ubicacion', 'email', 'sitioweb', 'ciudad_id', 'union_id', 'created_at', 'updated_at'
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

    public function union() {
        return $this->belongsTo('App\Union');
    }

    public function zonas() {
        return $this->hasMany('App\Zona');
    }

    public function distritos() {
        return $this->hasMany('App\Distrito');
    }

    public function agendaasociacions() {
        return $this->hasMany('App\Agendaasociacion');
    }
    
    public function anuncios() {
        return $this->hasMany('App\Anuncio');
    }

}
