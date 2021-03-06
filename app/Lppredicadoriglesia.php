<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lppredicadoriglesia extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'iglesia_id', 'feligres_id', 'listapredicacionfecha_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function listapredicacionfecha() {
        return $this->belongsTo('App\Listapredicacionfecha');
    }

    public function feligres() {
        return $this->belongsTo('App\Feligres');
    }

    public function iglesia() {
        return $this->belongsTo('App\Iglesia');
    }

}
