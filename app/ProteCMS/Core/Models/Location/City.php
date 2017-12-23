<?php

namespace App\ProteCMS\Core\Models\Location;

use App\ProteCMS\Core\Models\Webs\Web;
use App\ProteCMS\Core\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['state_id', 'name'];

    public function webs()
    {
        return $this->hasMany(Web::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
