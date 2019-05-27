<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerario extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'fecha', 'iglesia_id', 'periodo_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function iglesia() {
        return $this->belongsTo('App\Iglesia');
    }

    public function periodo() {
        return $this->belongsTo('App\Periodo');
    }

    public function itinerariodetalles() {
        return $this->hasMany('App\Itinerariodetalle');
    }

}
