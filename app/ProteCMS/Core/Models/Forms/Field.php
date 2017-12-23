<?php

namespace App\ProteCMS\Core\Models\Forms;

use App\ProteCMS\Core\Models\BaseModel;
use Dimsav\Translatable\Translatable;

class Field extends BaseModel
{
    use Translatable;

    public $translatedAttributes = ['title'];
    protected $table = 'forms_fields';
    protected $with = ['translations'];
    protected $touches = ['form'];
    protected $fillable = ['id', 'order', 'name', 'type', 'required'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
