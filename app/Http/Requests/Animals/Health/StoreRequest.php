<?php

namespace App\Http\Requests\Animals\Health;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'title'      => 'required',
            'type'       => 'required|in:'.implode(',', config('protecms.animals.health.type')),
            'medicine'   => '',
            'start_date' => '',
            'end_date'   => '',
            'cost'       => '',
            'text'       => '',
        ];
    }
}
