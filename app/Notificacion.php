<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'fecha', 'icono', 'action', 'estado', 'user_id', 'created_at', 'updated_at'
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

}
