<?php

namespace App\ProteCMS\Core\Models\Veterinarians;

use App\ProteCMS\Core\Models\Webs\Web;
use App\ProteCMS\Core\Models\BaseModel;
use App\ProteCMS\Core\Models\Location\City;
use App\ProteCMS\Core\Models\Location\State;
use App\ProteCMS\Core\Models\Location\Country;
use App\Helpers\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veterinary extends BaseModel
{
    use SoftDeletes, LogsActivity;

    protected $table = 'veterinarians';
    protected $touches = ['web'];
    protected $fillable = [
        'name', 'contact_name', 'email', 'phone', 'emergency_phone', 'status', 'address', 'city_id',
        'state_id', 'country_id', 'text',
    ];

    public function setAttribute($key, $value)
    {
        parent::setAttribute($key, $value);
    }

    public function web()
    {
        return $this->belongsTo(Web::class);
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
