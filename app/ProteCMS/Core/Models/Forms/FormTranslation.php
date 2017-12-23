<?php

namespace App\ProteCMS\Core\Models\Forms;

use Illuminate\Database\Eloquent\Model;

class FormTranslation extends Model
{
    protected $table = 'forms_translations';
    protected $fillable = ['title', 'slug', 'text', 'subject', 'user_id'];
}
