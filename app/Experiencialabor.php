<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experiencialabor extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'fechainicio', 'fechafin', 'labor_id', 'feligres_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function labor() {
        return $this->belongsTo('App\Labor');
    }

    public function feligres() {
        return $this->belongsTo('App\Feligres');
    }

}
