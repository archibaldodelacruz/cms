<?php

namespace App\Http\Requests\Forms;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    public function rules()
    {
        return [
            $this->get('langform').'.title'   => 'required',
            $this->get('langform').'.slug'    => 'required|alpha_dash',
            $this->get('langform').'.subject' => 'required',
            $this->get('langform').'.text'    => '',
            $this->get('langform').'.user_id' => 'required|exists:users,id',
            'status'                            => 'required|in:'.implode(',', config('protecms.forms.status')),
        ];
    }
}
