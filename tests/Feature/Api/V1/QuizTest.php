<?php

namespace Tests\Feature\Api\V1;

use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Purchase;
use App\Models\Question\QuestionCorrectChoice;
use App\Models\Question\QuestionEntryText;
use App\Models\Quiz;
use App\Models\User;
use App\Services\Api\V1\Admin\ContentService;
use App\Services\Api\V1\Admin\PurchaseService;
use App\Services\Api\V1\Admin\LessonService;
use App\Services\Api\V1\Admin\QuestionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Telescope\Telescope;
use Tests\TestCase;
use Throwable;

class QuizTest extends TestCase
{
    const URL = '/api/v1/quizzes';
    private array $requestData;
    private mixed $responseData;
    private array $requestDataPurchase;

    use RefreshDatabase;

    /**
     * @throws Throwable
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->purchaseService = app(PurchaseService::class);
        $this->quiestionService = app(QuestionService::class);

        $this->setUpStudentUser();

        Quiz::truncate();

        Telescope::startRecording();
    }

    public function test_quizzes()
    {
        $course = Course::factory()->create();
        $module = Module::factory()->create();
        $course->modules()->sync($module->id);

        $quiz = Quiz::factory()->create();
        $quiz->modules()->sync($module->id);

        $questionCorrectChoice = QuestionCorrectChoice::factory()->create();
        $questionCorrectChoice->quizzes()->sync($quiz->id);

        $questionEntryText = QuestionEntryText::factory()->create();
        $questionEntryText->quizzes()->sync($quiz->id);

        /** Show */
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->studentBearerToken,
            'Accept' => 'application/json',
            'Accept-Language' => 'ua',

        ])->getJson(self::URL . '/' . $quiz->id)
            ->assertJson(['data' => [...$quiz->toArray()]])
            ->assertJsonCount(2, 'data.questions')
            ->assertStatus(200);
    }
}
