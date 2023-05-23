<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Product;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductApiTest extends TestCase
{

    use RefreshDatabase;

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
            'email' => 'viraj@yahoo.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Vimal',
            ]);;
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
        $this->actingAs($user);

        $response1 = $this->postJson('/api/v1/products', [
            'name' => 'Biscuit',
            'description' => 'Biscuit Test',
            'price' => '250.32',
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $response = $this->getJson('/api/v1/products/' . json_decode($response1->getContent())->id);
        $response
            ->assertStatus(200);
    }

    public function test_update_product_get_success_response(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Product::factory(10)->create();

        $response1 = $this->postJson('/api/v1/products', [
            'name' => 'Biscuit',
            'description' => 'Biscuit Test',
            'price' => '250.32',
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ]);

        $response = $this->putJson('/api/v1/products/' . json_decode($response1->getContent())->id, [
            'name' => 'Biscuit',
            'description' => 'Biscuit Test',
            'price' => '150.32',
        ]);
        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Biscuit',
                'description' => 'Biscuit Test',
                'price' => '150.32'
            ]);
    }

    public function test_delete_product_get_no_content_response(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Product::factory(10)->create();

        $response1 = $this->postJson('/api/v1/products', [
            'name' => 'Biscuit',
            'description' => 'Biscuit Test',
            'price' => '250.32',
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ]);

        $response = $this->deleteJson('/api/v1/products/' . json_decode($response1->getContent())->id);
        $response
            ->assertStatus(204);
    }

    public function test_recaptcha_get_validation_response(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response1 = $this->getJson('/api/v1/recaptcha/verify', [
            'token' => 'testtoken',
        ]);

        $response1
            ->assertStatus(422)
            ->assertJsonFragment(
                [
                    "message" => "The token field is required.",
                    "errors" => [
                        "token" => [
                            "The token field is required."
                        ]
                    ]
                ]
            );
    }

    public function test_get_all_products(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Product::factory(10)->create();

        $response = $this->getJson('/api/v1/products');
        $response
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_get_all_products_with_filters(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->getJson('/api/v1/products?name=Bis');
        $response
            ->assertStatus(200)
            ->assertJsonCount(3);
    }
}
