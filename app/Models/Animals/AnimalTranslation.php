<?php

namespace App\Models\Animals;

use App\Models\BaseModel;

class AnimalTranslation extends BaseModel
{
    protected $table = 'animals_translations';
    protected $fillable = ['text', 'private_text', 'health_text', 'breed'];
}
