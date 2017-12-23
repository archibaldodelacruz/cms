<?php

namespace App\ProteCMS\Core\Models\Forms;

use App\ProteCMS\Core\Models\BaseModel;

class FieldTranslation extends BaseModel
{
    protected $table = 'forms_fields_translations';
    protected $fillable = ['title'];
}
