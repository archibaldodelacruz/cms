<?php

namespace App\Http\Requests\Animals\Notes;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            $this->get('langform').'.title' => 'required',
            $this->get('langform').'.text'  => 'required',
            'status'                        => 'required|in:'.implode(',', config('protecms.animals.notes.status')),
            'published_at'                  => 'required',
        ];
    }
}
