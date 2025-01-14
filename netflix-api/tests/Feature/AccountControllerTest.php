<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful login with valid credentials.
     */
    public function test_login_success()
    {
        // Create a test user
        DB::table('Account')->insert([
            'email' => 'user1@example.com',
            'hashed_password' => Hash::make('examplePassword1'),
            'subscription_id' => 1,
            'billed_from' => now(),
            'blocked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send login request
        $response = $this->postJson('/api/account/login', [
            'email' => 'user1@example.com',
            'password' => 'examplePassword1',
        ]);

        // Assert success
        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'token']);
    }

    /**
     * Test login fails with incorrect password.
     */
    public function test_login_fails_with_incorrect_password()
    {
        // Create a test user
        DB::table('Account')->insert([
            'email' => 'user1@example.com',
            'hashed_password' => Hash::make('examplePassword1'),
            'subscription_id' => 1,
            'billed_from' => now(),
            'blocked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send login request with incorrect password
        $response = $this->postJson('/api/account/login', [
            'email' => 'user1@example.com',
            'password' => 'wrongPassword',
        ]);

        // Assert unauthorized
        $response->assertStatus(401)
                 ->assertJson(['error' => 'Invalid credentials']);
    }

    /**
     * Test successful logout.
     */
    public function test_logout_success()
    {
        // Create a test token
        DB::table('tokens')->insert([
            'account_id' => 1,
            'token' => 'validToken',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send logout request
        $response = $this->postJson('/api/account/logout', [], [
            'Authorization' => 'Bearer validToken',
        ]);

        // Assert success
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Logged out successfully']);

        // Assert token is deleted
        $this->assertDatabaseMissing('tokens', ['token' => 'validToken']);
    }

    /**
     * Test logout fails without a token.
     */
    public function test_logout_fails_without_token()
    {
        // Send logout request without token
        $response = $this->postJson('/api/account/logout');

        // Assert bad request
        $response->assertStatus(400)
                 ->assertJson(['error' => 'No token provided']);
    }

    /**
     * Test successful registration.
     */
    public function test_register_success()
    {
        // Insert a test subscription
        DB::table('Subscription')->insert([
            'subscription_id' => 1,
            'subscription_name' => 'Basic',
            'subscription_price' => 7.99,
        ]);

        // Send registration request
        $response = $this->postJson('/api/account/register', [
            'email' => 'user2@example.com',
            'password' => 'examplePassword2',
            'password_confirmation' => 'examplePassword2',
            'subscription_id' => 1,
            'billed_from' => now()->toDateString(),
        ]);

        // Assert success
        $response->assertStatus(201)
                 ->assertJson(['message' => 'User registered successfully']);

        // Assert account exists in the database
        $this->assertDatabaseHas('Account', ['email' => 'user2@example.com']);
    }

    /**
     * Test registration fails with duplicate email.
     */
    public function test_register_fails_with_duplicate_email()
    {
        // Insert an existing user
        DB::table('Account')->insert([
            'email' => 'user1@example.com',
            'hashed_password' => Hash::make('examplePassword1'),
            'subscription_id' => 1,
            'billed_from' => now(),
        ]);

        // Send registration request with duplicate email
        $response = $this->postJson('/api/account/register', [
            'email' => 'user1@example.com',
            'password' => 'examplePassword2',
            'password_confirmation' => 'examplePassword2',
            'subscription_id' => 1,
            'billed_from' => now()->toDateString(),
        ]);

        // Assert unprocessable entity
        $response->assertStatus(422);
    }

    /**
     * Test blocking an account.
     */
    public function test_block_account_success()
    {
        // Create a test user
        DB::table('Account')->insert([
            'account_id' => 1,
            'email' => 'user1@example.com',
            'hashed_password' => Hash::make('examplePassword1'),
            'subscription_id' => 1,
            'billed_from' => now(),
            'blocked' => 0,
        ]);

        // Send block account request
        $response = $this->postJson('/api/account/block/1');

        // Assert success
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Account blocked successfully']);

        // Assert account is blocked in the database
        $this->assertDatabaseHas('Account', ['account_id' => 1, 'blocked' => 1]);
    }
}
