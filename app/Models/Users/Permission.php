<?php

namespace App\Models\Users;

use App\Models\BaseModel;

class Permission extends BaseModel
{
    protected $table = 'permissions';
    protected $fillable = ['id', 'permission'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
