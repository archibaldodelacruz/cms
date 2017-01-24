<?php

namespace App\Http\Requests\Files;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'title'   => 'required',
            'user_id' => 'required|exists:users,id',
            'file'    => '',
        ];
    }
}
