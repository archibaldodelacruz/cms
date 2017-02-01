<?php

namespace App\Models\Animals;

use App\Models\BaseModel;

class NoteTranslation extends BaseModel
{
    protected $table = 'animals_notes_translations';
    protected $fillable = ['title', 'text', 'user_id'];
}
