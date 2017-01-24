<?php

namespace App\Models\Calendar;

use App\Models\Webs\Web;
use App\Models\BaseModel;
use App\Helpers\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends BaseModel
{
    use SoftDeletes, LogsActivity;

    protected $table = 'calendar';
    protected $touches = ['web'];
    protected $appends = ['color'];
    protected $dates = ['start_date', 'end_date'];
    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'all_day', 'type'];

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['start_date', 'end_date'])) {
            if ($value !== '') {
                $value = date('Y-m-d H:i:s', strtotime($value));
            } else {
                $value = null;
            }
        }

        parent::setAttribute($key, $value);
    }

    public function getColorAttribute()
    {
        switch ($this->type) {
            case 'transport':
                return '#F44336';
                break;

            case 'vaccine':
                return '#C2185B';
                break;

            case 'revision':
                return '#9C27B0';
                break;

            case 'treatment':
                return '#2196F3';
                break;

            case 'work':
                return '#4CAF50';
                break;

            case 'visit':
                return '#FF9800';
                break;

            case 'other':
                return '#00BCD4';
                break;

            default:
                return '#2196F3';
                break;
        }
    }

    public function web()
    {
        return $this->belongsTo(Web::class);
    }
}
