<?php

namespace App\Models\Posts;

use App\Models\BaseModel;
use App\Models\Webs\Web;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use SoftDeletes, Translatable;

    public $translatedAttributes = ['title', 'slug', 'text'];
    protected $table = 'posts_categories';
    protected $with = ['translations'];
    protected $fillable = [];
    protected $touches = ['web'];

    public function web()
    {
        return $this->belongsTo(Web::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
