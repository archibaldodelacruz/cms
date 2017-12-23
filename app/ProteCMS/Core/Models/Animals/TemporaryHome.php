<?php

namespace App\ProteCMS\Core\Models\Animals;

use App\ProteCMS\Core\Models\Webs\Web;
use App\ProteCMS\Core\Models\BaseModel;
use App\ProteCMS\Core\Models\Location\City;
use App\ProteCMS\Core\Models\Location\State;
use App\ProteCMS\Core\Models\Location\Country;
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
