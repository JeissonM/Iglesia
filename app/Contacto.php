<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'feligres_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function feligres() {
        return $this->belongsTo('App\Feligres');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function chats() {
        return $this->hasMany('App\Chat');
    }

}
