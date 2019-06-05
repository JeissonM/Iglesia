<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pastor extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'pastor_desde', 'jubilado', 'fecha_jubilacion', 'situacion', 'pastor_sobre', 'distrito_id', 'iglesia_id', 'personanatural_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function personanatural() {
        return $this->belongsTo('App\Personanatural');
    }

    public function distrito() {
        return $this->belongsTo('App\Distrito');
    }

    public function iglesia() {
        return $this->belongsTo('App\Iglesia');
    }

    public function juntas() {
        return $this->hasMany('App\Junta');
    }

    public function sermons() {
        return $this->hasMany('App\Sermon');
    }

}
