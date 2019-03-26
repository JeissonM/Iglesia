<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Union extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'ubicacion', 'email', 'sitioweb', 'ciudad_id', 'division_id', 'created_at', 'updated_at'
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

    public function division() {
        return $this->belongsTo('App\Division');
    }

    public function asociacions() {
        return $this->hasMany('App\Asociacion');
    }

}
