<?php

namespace App\Models\Widgets;

use App\Helpers\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Models\Webs\Web;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Widget extends BaseModel
{
    use SoftDeletes, Translatable, LogsActivity;

    public $translatedAttributes = ['title', 'content'];
    protected $table = 'widgets';
    protected $touches = ['web'];
    protected $casts = ['config' => 'array'];
    protected $with = ['translations', 'links.translations'];
    protected $fillable = ['id', 'file', 'status', 'side', 'order', 'type', 'config'];

    public function getConfig($config)
    {
        if (isset($this->config[$config])) {
            return $this->config[$config];
        }

        return;
    }

    public function setConfigAttribute($request)
    {
        if ($request !== '0') {
            $config = $this->config;
            foreach ($request as $key => $value) {
                if ((bool) $value) {
                    $config[$key] = $value;
                } else {
                    unset($config[$key]);
                }
            }

            $this->attributes['config'] = json_encode($config);
        }
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function web()
    {
        return $this->belongsTo(Web::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
