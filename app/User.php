<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'identificacion', 'nombres', 'apellidos', 'email', 'password', 'estado', 'email_verified_at', 'user_change', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function grupousuarios() {
        return $this->belongsToMany('App\Grupousuario');
    }

    public function recursosministerials() {
        return $this->hasMany('App\Recursosministerial');
    }

    public function multimediaministerials() {
        return $this->hasMany('App\Multimediaministerial');
    }

    public function contactos() {
        return $this->hasMany('App\Contacto');
    }

    public function chats() {
        return $this->hasMany('App\Chat');
    }

    public function chatmensajes() {
        return $this->hasMany('App\Chatmensaje');
    }

}
