<?php

namespace App\Models\Partners;

use App\Helpers\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Models\Webs\Web;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends BaseModel
{
    use SoftDeletes, LogsActivity;

    protected $table = 'partners';
    protected $touches = ['web'];
    protected $dates = ['start_date', 'end_date'];
    protected $fillable = [
        'id', 'web_id', 'name', 'email', 'donation', 'donation_time', 'payment_method', 'city', 'start_date',
        'end_date', 'text', 'phone', 'address', 'city_id', 'state_id', 'country_id',
    ];

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['start_date', 'end_date'])) {
            if ($value != '') {
                $value = date('Y-m-d', strtotime($value));
            } else {
                $value = null;
            }
        }

        parent::setAttribute($key, $value);
    }

    public function web()
    {
        return $this->belongsTo(Web::class);
    }
}
