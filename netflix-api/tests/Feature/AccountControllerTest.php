<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login functionality.
     */
    public function testLoginSuccess()
    {
        // Prepare test data
        $password = 'password123';
        $user = DB::table('Account')->insertGetId([
            'email' => 'test@example.com',
            'hashed_password' => Hash::make($password),
            'subscription_id' => 1,
            'billed_from' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'user' => ['account_id', 'email', 'subscription_id', 'billed_from']]);
    }

    /**
     * Test login failure due to invalid credentials.
     */
    public function testLoginInvalidCredentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(404)
            ->assertJson(['error' => 'User not found']);
    }

    /**
     * Test registration functionality.
     */
    public function testRegisterSuccess()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'billed_from' => '2025-01-01',
            'subscription_id' => 1,
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'User registered successfully.']);
    }

    /**
     * Test logout functionality.
     */
    public function testLogoutSuccess()
    {
        // Prepare test data
        $token = bin2hex(random_bytes(40));
        DB::table('tokens')->insert([
            'account_id' => 1,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully']);
    }

    /**
     * Test password reset functionality.
     */
    public function testResetPasswordSuccess()
    {
        // Prepare test data
        $email = 'test@example.com';
        DB::table('Account')->insert([
            'email' => $email,
            'hashed_password' => Hash::make('oldpassword123'),
            'subscription_id' => 1,
            'billed_from' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $token = bin2hex(random_bytes(40));
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $response = $this->postJson('/api/reset-password', [
            'email' => $email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'token' => $token,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Password reset successfully']);
    }

    /**
     * Test block account functionality.
     */
    public function testBlockAccountSuccess()
    {
        // Prepare test data
        $accountId = DB::table('Account')->insertGetId([
            'email' => 'test@example.com',
            'hashed_password' => Hash::make('password123'),
            'billed_from' => now(),
            'subscription_id' => 1,
            'blocked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->postJson("/api/block-account/{$accountId}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Account blocked successfully']);
    }
}
