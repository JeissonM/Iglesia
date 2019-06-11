<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'contacto_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function contacto() {
        return $this->belongsTo('App\Contacto');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function chatmensajes() {
        return $this->hasMany('App\Chatmensaje');
    }

}
