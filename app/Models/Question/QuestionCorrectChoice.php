<?php

namespace App\Models\Question;

use App\Models\HasTranslation;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class QuestionCorrectChoice extends Model implements QuestionInterface
{
    const TYPE = 'correctChoice';

    use HasFactory, HasTranslation;

    protected $fillable = [
        'sort',
        'check_needed',
    ];

    protected $casts = [
        'check_needed' => 'boolean'
    ];

    protected array $translationFillable = [
        'language',
        'name',
        'description',
    ];

    public function checkAnswer(mixed $answer): bool
    {
        return $this->variants()->where([
            'id' => $answer,
            'is_correct' => true
        ])->count();
    }

    public function quizzes(): MorphToMany
    {
        return $this->morphToMany(Quiz::class, 'questionable');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(QuestionCorrectChoiceVariant::class);
    }
}
