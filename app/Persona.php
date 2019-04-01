<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tipopersona', 'direccion', 'mail', 'celular', 'telefono', 'numero_documento', 'lugar_expedicion', 'fecha_expedicion', 'nombrecomercial', 'regimen', 'tipodocumento_id', 'pais_id', 'estado_id', 'ciudad_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function personanaturals() {
        return $this->hasMany('App\Personanatural');
    }

    public function pais() {
        return $this->belongsTo('App\Pais');
    }

    public function estado() {
        return $this->belongsTo('App\Estado');
    }

    public function ciudad() {
        return $this->belongsTo('App\Ciudad');
    }

    public function tipodocumento() {
        return $this->belongsTo('App\Tipodocumento');
    }

}
