<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargogeneral extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'ministerio_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function ministerio() {
        return $this->belongsTo('App\Ministerio');
    }
    
    public function miembrojuntas() {
        return $this->hasMany('App\Miembrojunta');
    }

}
