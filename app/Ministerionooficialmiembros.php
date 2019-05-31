<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ministerionooficialmiembros extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'funcion', 'feligres_id', 'ministerioextra_id', 'created_at', 'updated_at'
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

    public function ministerioextra() {
        return $this->BelongsTo('App\Ministerioextra');
    }

}
