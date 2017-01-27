<?php

namespace App\Http\Requests\Animals;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name'                   => 'required',
            'old_name'               => '',
            'status'                 => 'required',
            'kind'                   => 'required|in:'.implode(',', \Auth::user()->animalsAllPermissions()),
            'location'               => 'required',
            'gender'                 => 'required',
            'visible'                => '',
            'microchip'              => '',
            'birth_date'             => '',
            'birth_date_approximate' => '',
            'entry_date'             => '',
            'entry_date_approximate' => '',
            'weight'                 => '',
            'height'                 => '',
        ];
    }
}
