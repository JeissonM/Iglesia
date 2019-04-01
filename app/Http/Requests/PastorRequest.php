<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PastorRequest extends FormRequest {

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
            'pastor_desde' => 'required',
            'jubilado' => 'required',
            'situacion' => 'required',
            'pastor_sobre' => 'required',
            'distrito_id' => 'required'
        ];
    }

}
