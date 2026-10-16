<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    protected string $submissionsDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->submissionsDir = storage_path('app/submissions');
    }

    protected function tearDown(): void
    {
        // Clean up test files created during testing
        if (File::isDirectory($this->submissionsDir)) {
            $testFiles = File::glob($this->submissionsDir . '/submission_*_test_*.json');
            foreach ($testFiles as $file) {
                File::delete($file);
            }
        }
        parent::tearDown();
    }

    public function test_home_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Основа веб-приложения на Laravel');
        $response->assertSee(config('app.timezone'));
    }

    public function test_feedback_form_page_is_accessible(): void
    {
        $response = $this->get('/feedback');
        $response->assertStatus(200);
        $response->assertSee('Форма обратной связи');
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="category"', false);
        $response->assertSee('name="topic"', false);
        $response->assertSee('name="message"', false);
    }

    public function test_form_validation_fails_when_fields_are_empty(): void
    {
        $response = $this->post('/feedback', []);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'topic',
            'category',
            'message',
        ]);
        $response->assertStatus(302);
    }

    public function test_form_validation_fails_with_invalid_email_and_short_message(): void
    {
        $response = $this->post('/feedback', [
            'name' => 'А', // too short (< 2)
            'email' => 'invalid-email',
            'topic' => 'Hi', // too short (< 3)
            'category' => 'НесуществующаяКатегория',
            'message' => 'Коротко', // too short (< 10)
        ]);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'topic',
            'category',
            'message',
        ]);
    }

    public function test_form_successfully_saves_data_to_unique_json_file(): void
    {
        $payload = [
            'name' => 'Алексей Тестов',
            'email' => 'alexey@example.com',
            'category' => 'Предложение',
            'topic' => 'Тестирование сохранения в JSON',
            'message' => 'Это полноценное тестовое сообщение длиной более 10 символов для проверки сохранения в файл.',
        ];

        $beforeCount = File::isDirectory($this->submissionsDir)
            ? count(File::glob($this->submissionsDir . '/*.json'))
            : 0;

        $response = $this->post('/feedback', $payload);

        $response->assertRedirect('/feedback');
        $response->assertSessionHas('success');
        $response->assertSessionHas('saved_file');

        $savedFileName = session('saved_file');
        $this->assertNotEmpty($savedFileName);
        $this->assertStringEndsWith('.json', $savedFileName);

        $savedFilePath = $this->submissionsDir . DIRECTORY_SEPARATOR . $savedFileName;
        $this->assertFileExists($savedFilePath);

        $jsonContent = json_decode(File::get($savedFilePath), true);
        $this->assertIsArray($jsonContent);
        $this->assertEquals('Алексей Тестов', $jsonContent['name']);
        $this->assertEquals('alexey@example.com', $jsonContent['email']);
        $this->assertEquals('Предложение', $jsonContent['category']);
        $this->assertEquals('Тестирование сохранения в JSON', $jsonContent['topic']);
        $this->assertEquals($payload['message'], $jsonContent['message']);
        $this->assertArrayHasKey('id', $jsonContent);
        $this->assertArrayHasKey('created_at', $jsonContent);

        $afterCount = count(File::glob($this->submissionsDir . '/*.json'));
        $this->assertEquals($beforeCount + 1, $afterCount);
    }

    public function test_submissions_table_page_displays_saved_data(): void
    {
        $response = $this->get('/submissions');
        $response->assertStatus(200);
        $response->assertSee('Полученные данные');
        $response->assertSee('Алексей Тестов');
        $response->assertSee('alexey@example.com');
        $response->assertSee('Предложение');
        $response->assertSee('Тестирование сохранения в JSON');
    }

    public function test_download_json_file_works(): void
    {
        $files = File::glob($this->submissionsDir . '/*.json');
        $this->assertNotEmpty($files);

        $latestFile = basename(end($files));
        $response = $this->get('/submissions/download/' . $latestFile);

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
    }
}
