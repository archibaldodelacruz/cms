<?php

namespace App\Http\Requests\Calendar;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'title'       => 'required',
            'all_day'     => 'required|boolean',
            'type'        => 'required|in:'.implode(',', config('protecms.calendar.type')),
            'description' => 'string',
        ];
    }
}
