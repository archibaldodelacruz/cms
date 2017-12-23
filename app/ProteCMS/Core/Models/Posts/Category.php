<?php

namespace App\ProteCMS\Core\Models\Posts;

use App\ProteCMS\Core\Models\Webs\Web;
use App\ProteCMS\Core\Models\BaseModel;
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
