<?php

namespace App\Models\Posts;

use App\Helpers\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Models\Forms\Form;
use App\Models\Users\User;
use App\Models\Webs\Web;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends BaseModel
{
    use LogsActivity, SoftDeletes, Translatable;

    public $translatedAttributes = ['title', 'slug', 'text', 'user_id'];
    protected $table = 'posts';
    protected $touches = ['web'];
    protected $with = ['translations'];
    protected $dates = ['published_at'];
    protected $fillable = ['id', 'status', 'comments_status', 'comments', 'published_at', 'category_id', 'form_id', 'fixed'];

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['published_at'])) {
            $value = date('Y-m-d H:i:s', strtotime($value));
        }

        parent::setAttribute($key, $value);
    }

    public function web()
    {
        return $this->belongsTo(Web::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
