<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Miembrojunta extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'feligres_id', 'cargogeneral_id', 'junta_id', 'created_at', 'updated_at'
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

    public function cargogeneral() {
        return $this->belongsTo('App\Cargogeneral');
    }

    public function junta() {
        return $this->belongsTo('App\Junta');
    }

}
