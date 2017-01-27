<?php

namespace App\Http\Requests\Veterinarians;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name'            => 'required',
            'contact_name'    => 'required',
            'email'           => 'email',
            'phone'           => '',
            'emergency_phone' => '',
            'address'         => '',
            'status'          => 'required|in:'.implode(',', config('protecms.veterinarians.status')),
            'country_id'      => 'exists:countries,id',
            'state_id'        => 'exists:states,id',
            'city_id'         => 'exists:cities,id',
            'text'            => '',
        ];
    }
}
