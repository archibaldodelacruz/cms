<?php

namespace App\ProteCMS\Core\Models\Posts;

use App\ProteCMS\Core\Models\BaseModel;
use App\ProteCMS\Core\Models\Users\User;
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
