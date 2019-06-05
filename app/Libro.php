<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'resumen', 'isbn', 'editorial', 'anio', 'imagen', 'documento', 'categorialibro_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function categoria() {
        return $this->belongsTo('App\Categorialibro');
    }

    public function autors() {
        return $this->hasMany('App\Autor');
    }

}
