<?php

namespace App\ProteCMS\Core\Models\Widgets;

use App\ProteCMS\Core\Models\BaseModel;

class WidgetTranslation extends BaseModel
{
    protected $table = 'widgets_translations';
    protected $fillable = ['title', 'content'];
}
