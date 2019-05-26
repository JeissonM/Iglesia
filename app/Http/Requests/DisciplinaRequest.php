<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisciplinaRequest extends FormRequest {

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
            'descripcion' => 'required',
            'fechainicio' => 'required',
            'feligres_id' => 'required',
            'reunionjunta_id' => 'required',
            'periodo_id' => 'required'
        ];
    }

}
