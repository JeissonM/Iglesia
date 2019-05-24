<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historicosituacion extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'situacionfeligres_id', 'feligres_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function situacionfeligres() {
        return $this->belongsTo('App\Situacionfeligres');
    }

    public function feligres() {
        return $this->belongsTo('App\Feligres');
    }

}
