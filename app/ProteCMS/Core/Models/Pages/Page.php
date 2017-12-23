<?php

namespace App\ProteCMS\Core\Models\Pages;

use App\ProteCMS\Core\Models\Webs\Web;
use App\ProteCMS\Core\Models\BaseModel;
use App\ProteCMS\Core\Models\Forms\Form;
use App\ProteCMS\Core\Models\Users\User;
use App\Helpers\Traits\LogsActivity;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel
{
    use SoftDeletes, Translatable, LogsActivity;

    public $translatedAttributes = ['title', 'slug', 'text', 'user_id'];
    protected $table = 'pages';
    protected $touches = ['web'];
    protected $dates = ['published_at'];
    protected $fillable = ['id', 'status', 'published_at', 'category_id', 'form_id'];

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

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
