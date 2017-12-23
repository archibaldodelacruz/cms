<?php

namespace App\ProteCMS\Core\Models;

use App\Helpers\Traits\FilterByWeb;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use FilterByWeb;

    public function setAttribute($key, $value)
    {
        if ($value === '') {
            $value = null;
        }

        return parent::setAttribute($key, $value);
    }
}
