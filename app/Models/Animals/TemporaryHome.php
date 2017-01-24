<?php

namespace App\Models\Animals;

use App\Models\Webs\Web;
use App\Models\BaseModel;
use App\Models\Location\City;
use App\Models\Location\State;
use App\Models\Location\Country;
use App\Helpers\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemporaryHome extends BaseModel
{
    use SoftDeletes, LogsActivity;

    protected $touches = ['web'];
    protected $table = 'temporary_homes';
    protected $fillable = ['name', 'email', 'phone', 'address', 'city_id', 'state_id', 'country_id', 'status', 'text'];

    public function web()
    {
        return $this->belongsTo(Web::class);
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
