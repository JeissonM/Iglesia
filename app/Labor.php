<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labor extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'categorialabor_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function categorialabor() {
        return $this->belongsTo('App\Categorialabor');
    }

}
