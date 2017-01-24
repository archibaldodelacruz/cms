<?php

namespace App\Http\Requests\TemporaryHomes;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name'       => 'required',
            'email'      => 'email',
            'phone'      => '',
            'address'    => '',
            'status'     => 'required|in:'.implode(',', config('protecms.temporaryhomes.status')),
            'country_id' => 'exists:countries,id',
            'state_id'   => 'exists:states,id',
            'city_id'    => 'exists:cities,id',
            'text'       => '',
        ];
    }
}
