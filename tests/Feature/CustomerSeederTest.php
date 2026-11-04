<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CustomerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeding_creates_five_customers_without_duplicates_on_repeated_runs(): void
    {
        $this->seed(CustomerSeeder::class);
        $this->seed(CustomerSeeder::class);

        $this->assertDatabaseCount('users', 5);

        foreach (range(1, 5) as $customerNumber) {
            $this->assertDatabaseHas('users', [
                'email' => "customer{$customerNumber}@example.com",
                'role' => User::ROLE_USER,
            ]);
        }
    }

    public function test_all_seeded_customers_can_log_in(): void
    {
        $this->seed(CustomerSeeder::class);

        foreach (range(1, 5) as $customerNumber) {
            $email = "customer{$customerNumber}@example.com";
            $customer = User::query()->where('email', $email)->firstOrFail();

            $response = $this->post(route('login'), [
                'email' => $email,
                'password' => 'password123',
            ]);

            $response->assertRedirect(route('customer.index', absolute: false));
            $this->assertAuthenticatedAs($customer);

            $this->post(route('logout'));
        }
    }
}
