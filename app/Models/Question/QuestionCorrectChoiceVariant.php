<?php

namespace App\Models\Question;

use App\Models\HasTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionCorrectChoiceVariant extends Model
{
    use HasFactory, HasTranslation;

    protected $fillable = [
        'sort',
        'is_correct',
        'question_correct_choice_id',
    ];

    protected array $translationFillable = [
        'language',
        'name',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    protected $hidden = [
        'is_correct'
    ];
}
