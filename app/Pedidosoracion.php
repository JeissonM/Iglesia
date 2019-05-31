<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedidosoracion extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'persona', 'pedido', 'correo', 'tipo', 'estado', 'feligres_id', 'ciudad_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function feligres() {
        return $this->belongsTo('App\Feligres');
    }

    public function ciudad() {
        return $this->belongsTo('App\Ciudad');
    }

}
