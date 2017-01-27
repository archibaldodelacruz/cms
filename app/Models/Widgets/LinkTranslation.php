<?php

namespace App\Models\Widgets;

use App\Models\BaseModel;

class LinkTranslation extends BaseModel
{
    protected $table = 'widgets_links_translations';
    protected $fillable = ['title', 'link'];
}
