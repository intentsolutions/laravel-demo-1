<?php

namespace App\Models\Content;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ContentVideo extends Model
{
    const TYPE = 'video';

    use HasFactory;

    protected $fillable = [
        'sort',
        'type',
        'url',
    ];

    public function lessons(): MorphToMany
    {
        return $this->morphToMany(Lesson::class, 'contentable');
    }
}
