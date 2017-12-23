<?php

namespace App\ProteCMS\Core\Models\Widgets;

use App\ProteCMS\Core\Models\BaseModel;

class LinkTranslation extends BaseModel
{
    protected $table = 'widgets_links_translations';
    protected $fillable = ['title', 'link'];
}
