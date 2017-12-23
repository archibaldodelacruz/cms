<?php

namespace App\ProteCMS\Core\Models\Files;

use App\ProteCMS\Core\Models\Webs\Web;
use App\ProteCMS\Core\Models\BaseModel;
use App\ProteCMS\Core\Models\Users\User;
use App\Helpers\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends BaseModel
{
    use SoftDeletes, LogsActivity;

    protected $table = 'files';
    protected $touches = ['web'];
    protected $fillable = ['web_id', 'user_id', 'title', 'description', 'file', 'extension', 'public'];

    public function web()
    {
        return $this->belongsTo(Web::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
