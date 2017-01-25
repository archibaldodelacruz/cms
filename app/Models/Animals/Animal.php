<?php

namespace App\Models\Animals;

use Carbon\Carbon;
use App\Models\Webs\Web;
use App\Models\BaseModel;
use App\Helpers\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends BaseModel
{
    use SoftDeletes, Translatable, LogsActivity;

    public $translatedAttributes = ['text', 'private_text', 'health_text', 'breed'];
    protected $meta;
    protected $table = 'animals';
    protected $casts = ['meta' => 'array'];
    protected $dates = ['birth_date', 'entry_date'];
    protected $touches = ['web'];
    protected $fillable = [
        'id', 'web_id', 'name', 'old_name', 'status', 'kind', 'location', 'gender', 'visible', 'litter', 'identifier',
        'meta', 'microchip', 'birth_date', 'birth_date_approximate', 'entry_date', 'entry_date_approximate', 'weight', 'height',
        'length', 'temporary_home_id', 'created_at', 'updated_at',
    ];

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['birth_date', 'entry_date'])) {
            if ($value !== '') {
                $value = date('Y-m-d', strtotime($value));
            } else {
                $value = null;
            }
        }

        parent::setAttribute($key, $value);
    }

    public function birthDateDiffForHumans()
    {
        $date = $this->birth_date;
        if (Carbon::now()->diffInMonths($date) >= 12) {
            $years = Carbon::now()->diffInYears($date);
        } else {
            $years = null;
        }

        $date = $years ? $date->addYears($years) : $date;

        if (Carbon::now()->diffInMonths($date) >= 1) {
            $months = Carbon::now()->diffInMonths($date);
        } else {
            $months = null;
        }

        $date = $months ? $date->addMonths($months) : $date;

        if (Carbon::now()->diffInDays($date) >= 1) {
            $days = Carbon::now()->diffInDays($date);
        } else {
            $days = null;
        }

        if ($years && $months) {
            if ($this->birth_date_approximate) {
                return Carbon::getTranslator()->transChoice('year', $years, [':count' => $years]);
            }

            return Carbon::getTranslator()->transChoice(
                'year',
                $years,
                [':count' => $years]).' y '.Carbon::getTranslator()->transChoice('month', $months, [':count' => $months]
            );
        } elseif ($years && !$months) {
            return Carbon::getTranslator()->transChoice('year', $years, [':count' => $years]);
        } elseif (! $years && $months && !$days) {
            return Carbon::getTranslator()->transChoice('month', $months, [':count' => $months]);
        } elseif (! $years && $months && $days) {
            if ($this->birth_date_approximate) {
                return Carbon::getTranslator()->transChoice('month', $months, [':count' => $months]);
            }

            return Carbon::getTranslator()->transChoice(
                'month',
                $months,
                [':count' => $months]).' y '.Carbon::getTranslator()->transChoice('day', $days, [':count' => $days]
            );
        }

        if ($days == 0) {
            $days = 1;
        }

        return Carbon::getTranslator()->transChoice('day', $days, [':count' => $days]);
    }

    public function scopePermission($query)
    {
        return $query->whereIn('kind', Auth::user()->animalsPermissions());
    }

    public function web()
    {
        return $this->belongsTo(Web::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function photos()
    {
        return $this->hasMany(Media::class)->where('type', 'photo');
    }

    public function main_photo()
    {
        return $this->photos()->where('type', 'photo')->orderBy('main', 'DESC')->first();
    }

    public function videos()
    {
        return $this->hasMany(Media::class)->where('type', 'video');
    }

    public function health()
    {
        return $this->hasMany(Health::class);
    }

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }

    public function public_sponsorships()
    {
        return $this->hasMany(Sponsorship::class)->where('visible', 'visible');
    }
}
