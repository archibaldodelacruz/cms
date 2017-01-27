<?php

namespace App\Models\Widgets;

use App\Models\BaseModel;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends BaseModel
{
    use SoftDeletes, Translatable;

    public $translatedAttributes = ['title', 'link'];
    protected $table = 'widgets_links';
    protected $with = ['translations'];
    protected $touches = ['widget'];
    protected $fillable = ['widget_id', 'type', 'order'];

    public function widget()
    {
        return $this->belongsTo(Widget::class);
    }
}
