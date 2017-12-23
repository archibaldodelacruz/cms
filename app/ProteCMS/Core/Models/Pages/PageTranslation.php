<?php

namespace App\ProteCMS\Core\Models\Pages;

use App\ProteCMS\Core\Models\BaseModel;

class PageTranslation extends BaseModel
{
    protected $table = 'pages_translations';
    protected $fillable = ['title', 'slug', 'text', 'user_id'];
}
