<?php

namespace App\Models\Animals;

use App\Models\BaseModel;
use App\Models\Users\User;
use App\Helpers\Traits\LogsActivity;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends BaseModel
{
    use SoftDeletes, Translatable, LogsActivity;

    public $translatedAttributes = ['title', 'text', 'user_id'];
    protected $table = 'animals_notes';
    protected $dates = ['published_at'];
    protected $touches = ['animal'];
    protected $fillable = [
        'animal_id', 'published_at', 'status'
    ];

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['published_at'])) {
            if ($value !== '') {
                $value = date('Y-m-d H:i:s', strtotime($value));
            } else {
                $value = null;
            }
        }

        parent::setAttribute($key, $value);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
