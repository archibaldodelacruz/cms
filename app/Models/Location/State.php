<?php

namespace App\Models\Location;

use App\Models\Users\User;
use App\Models\Webs\Web;
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
