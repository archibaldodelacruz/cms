<?php

namespace App\Helpers\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByWeb
{
    protected static $excludedTables = [
        'webs_config', 'users',
    ];

    public static function getTableName() : string
    {
        return with(new static())->getTable();
    }

    protected static function boot()
    {
        parent::boot();

        if (method_exists(get_called_class(), 'web')
            && ! in_array(self::getTableName(), self::$excludedTables)) {
            if (! app()->runningInConsole() || app()->environment() === 'testing') {
                static::creating(function ($model) {
                    $model->web_id = app('App\ProteCMS\Core\Models\Webs\Web')->id;
                });
            }

            static::addGlobalScope('web', function (Builder $builder) {
                if (app('App\ProteCMS\Core\Models\Webs\Web')->subdomain === 'admin' && app('App\ProteCMS\Core\Models\Webs\Web')->getConfig('web')) {
                    $builder->where('web_id', app('App\ProteCMS\Core\Models\Webs\Web')->getConfig('web'));
                } elseif (app('App\ProteCMS\Core\Models\Webs\Web')->subdomain !== 'admin') {
                    $builder->where('web_id', app('App\ProteCMS\Core\Models\Webs\Web')->id);
                }
            });
        }
    }
}
