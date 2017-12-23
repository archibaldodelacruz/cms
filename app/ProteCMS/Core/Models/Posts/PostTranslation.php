<?php

namespace App\ProteCMS\Core\Models\Posts;

use App\ProteCMS\Core\Models\BaseModel;
use App\ProteCMS\Core\Models\Users\User;

class PostTranslation extends BaseModel
{
    protected $table = 'posts_translations';
    protected $fillable = ['title', 'slug', 'text', 'user_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
