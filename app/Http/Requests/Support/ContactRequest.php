<?php

namespace App\Http\Requests\Support;

use App\Http\Requests\BaseRequest;

class ContactRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'title'   => 'required',
            'message' => 'required',
            'subject' => 'required|in:suggestion,error,other',
        ];
    }
}
