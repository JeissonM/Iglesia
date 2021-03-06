<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ministerioextra extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'presentacion', 'tipoministerio_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function tipoministerio() {
        return $this->belongsTo('App\Tipoministerio');
    }

    public function ministerionooficialmiembros() {
        return $this->hasMany('App\Ministerionooficialmiembros');
    }

    public function multimediaministerials() {
        return $this->hasMany('App\Multimediaministerial');
    }

}
