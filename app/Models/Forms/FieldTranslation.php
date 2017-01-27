<?php

namespace App\Models\Forms;

use App\Models\BaseModel;

class FieldTranslation extends BaseModel
{
    protected $table = 'forms_fields_translations';
    protected $fillable = ['title'];
}
