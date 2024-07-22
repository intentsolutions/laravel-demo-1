<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Throwable;

class QuizTest extends TestCase
{
    const URL = '/api/v1/admin/quizzes';
    private array $requestData;
    private mixed $responseData;

    use RefreshDatabase;

    /**
     * @throws Throwable
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpAdminUser();
        $this->setUpMediaFile();
        $this->setUpMockData();

        Quiz::truncate();
    }

    private function setUpMockData(): void
    {
        $module = Module::factory()->create();

        $this->requestData = [
            'sort' => 0,
            'status' => true,
            'translations' => [
                'en' => [
                    'language' => 'en',
                    'name' => 'test name',
                    'description' => 'test description',
                ],
                'ua' => [
                    'language' => 'ua',
                    'name' => 'test ua name',
                    'description' => 'test ua description',
                ],
            ],
            'modules' => [$module->id]
        ];

        $this->responseData = $this->requestData;
        $this->responseData['modules'] = [['id' => $module->id, 'translations' => []]];
    }

    public function test_admin_lessons()
    {
        /** Create */
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->adminBearerToken,
            'Accept' => 'application/json'
        ])->postJson(self::URL, $this->requestData);

        $entityId = $response->json('data.id');

        $response->assertJson(['data' => $this->responseData])
            ->assertStatus(201);

        /** List */
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->adminBearerToken,
            'Accept' => 'application/json'
        ])->getJson(self::URL)
            ->assertJson(['data' => [$this->responseData]])
            ->assertStatus(200);

        /** Show */
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->adminBearerToken,
            'Accept' => 'application/json'
        ])->getJson(self::URL . '/' . $entityId)
            ->assertJson(['data' => $this->responseData])
            ->assertStatus(200);

        /** Edit */
        $entity = Quiz::factory()->create();

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->adminBearerToken,
            'Accept' => 'application/json'
        ])->putJson(self::URL . '/' . $entity->id, $this->requestData)
            ->assertJson(['data' => $this->responseData])
            ->assertStatus(200);

        /** Delete */
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->adminBearerToken,
            'Accept' => 'application/json'
        ])->deleteJson(self::URL . '/' . $entityId)
            ->assertStatus(204);
    }
}
