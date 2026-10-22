<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SimpleAppTest extends TestCase
{
    public function test_pages_are_accessible(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/form')->assertStatus(200);
        $this->get('/data')->assertStatus(200);
    }

    public function test_form_validation(): void
    {
        $response = $this->post('/form', []);
        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_form_saves_to_json_and_displays_in_table(): void
    {
        $payload = [
            'name' => 'Иван',
            'email' => 'ivan@example.com',
            'message' => 'Тестовое сообщение',
        ];

        $response = $this->post('/form', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $files = File::glob(storage_path('app/data/*.json'));
        $this->assertNotEmpty($files);

        $tableResponse = $this->get('/data');
        $tableResponse->assertStatus(200);
        $tableResponse->assertSee('Иван');
        $tableResponse->assertSee('ivan@example.com');
    }
}
