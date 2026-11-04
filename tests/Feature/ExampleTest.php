<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_welcome_screen_can_be_rendered_with_login_and_register_links(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('Log in')
            ->assertSee('Register');
    }

    public function test_customer_page_is_publicly_accessible(): void
    {
        $response = $this->get(route('customer.index'));

        $response->assertStatus(200);
    }
}
