<?php

namespace App\Models\Widgets;

use App\Models\BaseModel;

class WidgetTranslation extends BaseModel
{
    protected $table = 'widgets_translations';
    protected $fillable = ['title', 'content'];
}
