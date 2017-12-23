<?php

namespace App\ProteCMS\Core\Models\Animals;

use App\ProteCMS\Core\Models\BaseModel;

class NoteTranslation extends BaseModel
{
    protected $table = 'animals_notes_translations';
    protected $fillable = ['title', 'text', 'user_id'];
}
