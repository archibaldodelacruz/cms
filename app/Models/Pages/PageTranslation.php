<?php

namespace App\Models\Pages;

use App\Models\BaseModel;

class PageTranslation extends BaseModel
{
    protected $table = 'pages_translations';
    protected $fillable = ['title', 'slug', 'text', 'user_id'];
}
