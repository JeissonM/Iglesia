<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sermon extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'descripcion', 'tipoautor', 'tipo', 'archivo', 'otro', 'feligres_id', 'pastor_id', 'created_at', 'updated_at'
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

    public function pastor() {
        return $this->belongsTo('App\Pastor');
    }

}
