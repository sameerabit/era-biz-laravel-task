<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductApiTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_create_product_when_unauthorized(): void
    {
        $response = $this->postJson('/api/v1/products', [
            'name' => 'Biscuit',
            'description' => 'Test Biscuit',
            'price' => 120.50,
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $response
            ->assertStatus(401);
    }

    public function test_register_user(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Vimal',
            'email' => fake()->email,
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Vimal',
            ]);;
    }

    public function test_login_user(): void
    {
        $response = $this->postJson('/api/v1/login', [
            'email' => 'vimal@yahoo.com',
            'password' => '123456',
        ]);
        $response
            ->assertStatus(201);
    }

    public function test_create_product_get_success_response(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/v1/products', [
            'name' => 'Biscuit',
            'description' => 'Biscuit Test',
            'price' => '250.32',
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Biscuit',
                'description' => 'Biscuit Test',
                'price' => '250.32'
            ]);
    }

    public function test_get_product_get_success_response(): void
    {
        $user = User::factory()->create();
        $this->assertCount(0, $user->tokens);

        $this->actingAs($user);

        $response = $this->getJson('/api/v1/products/5');
        $response
            ->assertStatus(200);
    }

    public function test_update_product_get_success_response(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/v1/products/6', [
            'name' => 'Biscuit',
            'description' => 'Biscuit Test',
            'price' => '250.32',
        ]);
        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Biscuit',
                'description' => 'Biscuit Test',
                'price' => '250.32'
            ]);
    }
}
