<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recursosministerial extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'user_id', 'ministerio_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function ministerio() {
        return $this->belongsTo('App\Ministerio');
    }

    public function recursosministerialitems() {
        return $this->hasMany('App\Recursosministerialitem');
    }

}
