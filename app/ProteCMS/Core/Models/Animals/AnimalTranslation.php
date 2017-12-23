<?php

namespace App\ProteCMS\Core\Models\Animals;

use App\ProteCMS\Core\Models\BaseModel;

class AnimalTranslation extends BaseModel
{
    protected $table = 'animals_translations';
    protected $fillable = ['text', 'private_text', 'health_text', 'breed'];
}
