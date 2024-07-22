<?php

namespace Database\Factories\Question;

use App\Models\Question\QuestionCorrectChoice;
use App\Models\Question\QuestionCorrectChoiceVariant;
use App\Models\Question\QuestionEntryText;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionEntryTextFactory extends Factory
{
    protected $model = QuestionEntryText::class;

    public function definition(): array
    {
        return [
            'sort' => 1,
            'check_needed' => true
        ];
    }

    public function configure(): QuestionEntryTextFactory
    {
        return $this->afterCreating(function (QuestionEntryText $questionEntryText) {
            $questionEntryText->translations()->create([
                'language' => 'en',
                'name' => 'title',
                'description' => 'text',
            ]);
            $questionEntryText->translations()->create([
                'language' => 'ua',
                'name' => 'title',
                'description' => 'text',
            ]);
        });
    }
}
