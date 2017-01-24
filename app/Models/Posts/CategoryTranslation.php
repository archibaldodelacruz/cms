<?php

namespace App\Models\Posts;

use App\Models\BaseModel;

class CategoryTranslation extends BaseModel
{
    protected $table = 'posts_categories_translations';

    protected $fillable = ['title', 'slug', 'text'];
}
