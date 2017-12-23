<?php

namespace App\ProteCMS\Core\Models\Location;

use App\ProteCMS\Core\Models\Webs\Web;
use App\ProteCMS\Core\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['country_id', 'name'];

    public function webs()
    {
        return $this->hasMany(Web::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
