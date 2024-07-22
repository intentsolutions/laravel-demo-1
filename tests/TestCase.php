<?php

declare(strict_types=1);

namespace Tests;

use App\Models\TempMediaFile;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Telescope\Telescope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected ?string $adminBearerToken = null;
    protected ?string $studentBearerToken = null;
    protected ?Media $mediaFile = null;

    /**
     * @return void
     * @throws \Throwable
     */
    protected function setUpAdminUser(): void
    {
        if (!$this->adminBearerToken) {
            if (!User::whereEmail('admin@admin.com')->exists()) {
                Artisan::call('db:seed');
            }

            $response = $this->postJson('/api/v1/tokens', [
                'email' => 'admin@admin.com',
                'password' => 'demo1234',
                'device_name' => 'testing',
                'user_type' => 'admin',
            ]);

            $this->adminBearerToken = $response->decodeResponseJson()['token'];
        }
    }

    /**
     * @return void
     * @throws \Throwable
     */
    protected function setUpStudentUser(): void
    {
        if (!$this->studentBearerToken) {
            if (!User::whereEmail('student@student.com')->exists()) {
                Artisan::call('db:seed');
            }

            $response = $this->postJson('/api/v1/tokens', [
                'email' => 'student@student.com',
                'password' => 'demo1234',
                'device_name' => 'testing',
            ]);

            $this->studentBearerToken = $response->decodeResponseJson()['token'];
        }
    }

    /**
     * @return void
     * @throws \Throwable
     */
    protected function setUpMediaFile(): void
    {
        if (!$this->mediaFile) {
            $file = Media::create([
                'model_type' => TempMediaFile::class,
                'model_id' => 1,
                'collection_name' => 'test_temp_file',
                'name' => 'test_temp_file',
                'file_name' => 'test_temp_file',
                'disk' => 'public',
                'size' => 0,
                'manipulations' => '{}',
                'custom_properties' => [],
                'generated_conversions' => '{}',
                'responsive_images' => '{}',
            ]);

            $this->mediaFile = $file;
        }
    }


}
