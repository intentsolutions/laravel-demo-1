<?php

namespace Database\Factories\Question;

use App\Models\Question\QuestionCorrectChoice;
use App\Models\Question\QuestionCorrectChoiceVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionCorrectChoiceFactory extends Factory
{
    protected $model = QuestionCorrectChoice::class;

    public function definition(): array
    {
        return [
            'sort' => 2,
            'check_needed' => true
        ];
    }

    public function configure(): QuestionCorrectChoiceFactory
    {
        return $this->afterCreating(function (QuestionCorrectChoice $questionCorrectChoice) {
            $questionCorrectChoice->translations()->create([
                'language' => 'en',
                'name' => 'Question Correct Choice #' . $questionCorrectChoice->id,
                'description' => $this->faker->text(100),
            ]);
            $questionCorrectChoice->translations()->create([
                'language' => 'ua',
                'name' => 'Питання Правильний вибір #' . $questionCorrectChoice->id,
                'description' => $this->faker->text(100),
            ]);

            QuestionCorrectChoiceVariant::factory()->create(
                ['question_correct_choice_id' => $questionCorrectChoice->id, 'is_correct' => true,]
            );

            QuestionCorrectChoiceVariant::factory()->create(
                ['question_correct_choice_id' => $questionCorrectChoice->id]
            );
        });
    }
}
