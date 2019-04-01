<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeligresRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'estado_actual' => 'required',
            'fecha_bautismo' => 'required',
            'asociacion_destino' => 'required',
            'distrito_destino' => 'required',
            'iglesia_destino' => 'required',
            'personanatural_id' => 'required'
        ];
    }

}
