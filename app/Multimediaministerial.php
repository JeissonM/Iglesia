<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multimediaministerial extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'tipo', 'user_id', 'ministerioextra_id', 'created_at', 'updated_at'
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

    public function ministerioextra() {
        return $this->belongsTo('App\Ministerioextra');
    }

    public function multimediaministerialitems() {
        return $this->hasMany('App\Multimediaministerialitem');
    }

}
