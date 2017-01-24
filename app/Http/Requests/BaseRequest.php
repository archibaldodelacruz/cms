<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        flash('Ha ocurrido un error al enviar el formulario. Revisa los campos.', 'error');

        return parent::failedValidation($validator);
    }
}
