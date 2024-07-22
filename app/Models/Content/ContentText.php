<?php

namespace App\Models\Content;

use App\Models\HasTranslation;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ContentText extends Model
{
    const TYPE = 'text';

    use HasFactory, HasTranslation;

    protected $fillable = [
        'sort',
    ];

    protected array $translationFillable = [
        'language',
        'name',
        'text',
    ];

    public function lessons(): MorphToMany
    {
        return $this->morphToMany(Lesson::class, 'contentable');
    }
}
