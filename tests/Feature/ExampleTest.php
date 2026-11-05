<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->withoutExceptionHandling();
        try {
            $response = $this->get('/');
            $response->assertStatus(200);
        } catch (\Throwable $e) {
            dump(get_class($e), $e->getMessage());
            throw $e;
        }
    }
}
