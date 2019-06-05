<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iglesiamapa extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'telefonocontacto', 'mapa', 'iglesia_id', 'created_at', 'updated_at'
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

}
