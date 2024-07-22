<?php

namespace Database\Factories\Question;

use App\Models\Question\QuestionCorrectChoiceVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionCorrectChoiceVariantFactory extends Factory
{
    protected $model = QuestionCorrectChoiceVariant::class;

    public function definition(): array
    {
        return [
            'sort' => 0,
            'is_correct' => false,
            'question_correct_choice_id' => null,
        ];
    }

    public function configure(): QuestionCorrectChoiceVariantFactory
    {
        return $this->afterCreating(function (QuestionCorrectChoiceVariant $questionCorrectChoiceVariant) {
            $questionCorrectChoiceVariant->translations()->create([
                'language' => 'en',
                'name' => 'Питання Варіант правильного вибору #'.$questionCorrectChoiceVariant->id,
            ]);
            $questionCorrectChoiceVariant->translations()->create([
                'language' => 'ua',
                'name' => 'Question Correct Choice Variant #'.$questionCorrectChoiceVariant->id,
            ]);
        });
    }
}
