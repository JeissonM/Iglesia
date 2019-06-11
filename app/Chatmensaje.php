<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatmensaje extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'mensaje', 'user_id', 'chat_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function chat() {
        return $this->belongsTo('App\Chat');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

}
