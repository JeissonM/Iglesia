<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personanatural extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'primer_nombre', 'segundo_nombre', 'sexo', 'fecha_nacimiento', 'libreta_militar', 'edad', 'rh', 'primer_apellido', 'segundo_apellido', 'distrito_militar', 'numero_pasaporte', 'otra_nacionalidad', 'email_institucional', 'clase_libreta', 'vive', 'fax', 'padre', 'madre', 'ocupacion', 'profesion', 'nivel_estudio', 'ultimo_grado', 'religion_anterior', 'ciudad_id', 'estado_id', 'pais_id', 'persona_id', 'estadocivil_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function pais() {
        return $this->belongsTo('App\Pais');
    }

    public function estado() {
        return $this->belongsTo('App\Estado');
    }

    public function ciudad() {
        return $this->belongsTo('App\Ciudad');
    }

    public function persona() {
        return $this->belongsTo('App\Persona');
    }

    public function estadocivil() {
        return $this->belongsTo('App\Estadocivil');
    }
    
    public function pastors() {
        return $this->hasMany('App\Pastor');
    }
    
    public function feligres() {
        return $this->hasMany('App\Feligres');
    }

}
