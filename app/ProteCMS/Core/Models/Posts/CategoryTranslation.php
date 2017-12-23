<?php

namespace App\ProteCMS\Core\Models\Posts;

use App\ProteCMS\Core\Models\BaseModel;

class CategoryTranslation extends BaseModel
{
    protected $table = 'posts_categories_translations';

    protected $fillable = ['title', 'slug', 'text'];
}
