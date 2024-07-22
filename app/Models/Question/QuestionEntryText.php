<?php

namespace App\Models\Question;

use App\Models\HasTranslation;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class QuestionEntryText extends Model implements QuestionInterface
{
    const TYPE = 'entryText';

    use HasFactory, HasTranslation;

    protected $fillable = [
        'sort',
        'check_needed',
    ];

    protected array $translationFillable = [
        'language',
        'name',
        'description',
    ];

    public function quizzes(): MorphToMany
    {
        return $this->morphToMany(Quiz::class, 'questionable');
    }

    public function checkAnswer(mixed $answer): bool
    {
        return false;
    }
}
