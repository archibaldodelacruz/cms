<?php

namespace App\ProteCMS\Core\Models\Webs;

use App\ProteCMS\Core\Models\BaseModel;

class Config extends BaseModel
{
    protected $table = 'webs_config';
    protected $fillable = ['web_id', 'key', 'value'];

    public function getValueAttribute($value)
    {
        if ($value instanceof \Traversable) {
            return (array) $value;
        }

        return $value;
    }

    public function web()
    {
        return $this->belongsTo(Web::class);
    }
}
