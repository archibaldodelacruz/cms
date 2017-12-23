<?php

namespace App\ProteCMS\Core\Models\Users;

use App\ProteCMS\Core\Models\BaseModel;

class Permission extends BaseModel
{
    protected $table = 'permissions';
    protected $fillable = ['id', 'permission'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
