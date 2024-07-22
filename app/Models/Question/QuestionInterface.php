<?php

namespace App\Models\Question;

interface QuestionInterface
{
    public function checkAnswer(mixed $answer): bool;
}
