<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listapredicacionfecha extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'fecha', 'diasemana', 'listapredicacion_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function listapredicacion() {
        return $this->belongsTo('App\Listapredicacion');
    }
    
    public function lppredicadoriglesias() {
        return $this->hasMany('App\Lppredicadoriglesia');
    }

}
