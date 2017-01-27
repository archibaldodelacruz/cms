<?php

namespace App\Models\Posts;

use App\Models\BaseModel;
use App\Models\Users\User;
use App\Helpers\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends BaseModel
{
    use SoftDeletes, LogsActivity;

    protected $table = 'posts_comments';
    protected $fillable = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
