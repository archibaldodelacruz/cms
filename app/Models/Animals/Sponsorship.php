<?php

namespace App\Models\Animals;

use App\Helpers\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Models\Location\City;
use App\Models\Location\Country;
use App\Models\Location\State;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsorship extends BaseModel
{
    use SoftDeletes, LogsActivity;

    protected $touches = ['animal'];
    protected $table = 'animals_sponsorships';
    protected $dates = ['start_date', 'end_date'];
    protected $fillable = [
        'name', 'email', 'phone', 'start_date', 'end_date', 'donation', 'donation_time', 'payment_method', 'address', 'city_id',
        'state_id', 'country_id', 'status', 'text', 'visible',
    ];

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['start_date', 'end_date'])) {
            if ($value !== '') {
                $value = date('Y-m-d', strtotime($value));
            } else {
                $value = null;
            }
        }

        parent::setAttribute($key, $value);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
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
