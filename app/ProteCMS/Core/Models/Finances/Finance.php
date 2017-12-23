<?php

namespace App\ProteCMS\Core\Models\Finances;

use App\ProteCMS\Core\Models\Webs\Web;
use App\ProteCMS\Core\Models\BaseModel;
use App\Helpers\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finance extends BaseModel
{
    use SoftDeletes, LogsActivity;

    protected $table = 'finances';
    protected $touches = ['web'];
    protected $dates = ['executed_at'];
    protected $fillable = ['title', 'description', 'amount', 'type', 'reason', 'executed_at'];

    public function isIncome()
    {
        return $this->type === 'income';
    }

    public function isSpending()
    {
        return $this->type === 'spending';
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['executed_at'])) {
            $value = date('Y-m-d H:i:s', strtotime($value));
        }

        parent::setAttribute($key, $value);
    }

    public function web()
    {
        return $this->belongsTo(Web::class);
    }
}
