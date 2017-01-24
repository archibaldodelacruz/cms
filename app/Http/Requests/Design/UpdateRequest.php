<?php

namespace App\Http\Requests\Design;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'color'  => 'required',
            'logo'   => 'string',
            'header' => 'string',
        ];
    }
}
