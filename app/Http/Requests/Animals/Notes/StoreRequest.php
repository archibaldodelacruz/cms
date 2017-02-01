<?php

namespace App\Http\Requests\Animals\Notes;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    public function rules()
    {
        return [
            config('app.locale').'.title'   => 'required',
            config('app.locale').'.text'    => 'required',
            config('app.locale').'.user_id' => 'required|exists:users,id',
            'status'                        => 'required|in:'.implode(',', config('protecms.animals.notes.status')),
            'published_at'                  => 'required',
        ];
    }
}
