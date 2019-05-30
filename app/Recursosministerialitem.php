<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recursosministerialitem extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'recurso', 'recursosministerial_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function recursosministerial() {
        return $this->belongsTo('App\Recursosministerial');
    }

}
