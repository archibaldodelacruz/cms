<?php

namespace App\Http\Requests\Partners;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name'          => 'required',
            'email'         => 'email',
            'donation'      => 'required|numeric',
            'start_date'    => 'date',
            'end_date'      => 'date',
            'donation_time' => 'required|in:'.implode(',', config('protecms.partners.donation_time')),
            'text'          => '',
        ];
    }
}
