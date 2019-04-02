<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conocimiento extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'feligres_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function feligres() {
        return $this->belongsTo('App\Feligres');
    }

}
