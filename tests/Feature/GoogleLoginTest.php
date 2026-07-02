<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_login_creates_user_and_returns_token()
    {
        Http::fake([
            'https://oauth2.googleapis.com/tokeninfo*' => Http::response([
                'aud' => config('services.google.client_id'),
                'iss' => 'https://accounts.google.com',
                'exp' => time() + 3600,
                'email' => 'testuser@example.com',
                'sub' => 'google-sub-123',
                'name' => 'Test User',
                'picture' => 'https://example.com/avatar.jpg',
                'email_verified' => 'true',
            ], 200),
        ]);

        $response = $this->postJson('/api/login/google', [
            'id_token' => 'dummy-id-token',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user', 'token'])
            ->assertJsonPath('user.email', 'testuser@example.com');

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'google_id' => 'google-sub-123',
        ]);
    }

    public function test_google_login_accepts_frontend_credential_payload()
    {
        Http::fake([
            'https://oauth2.googleapis.com/tokeninfo*' => Http::response([
                'aud' => config('services.google.client_id'),
                'iss' => 'https://accounts.google.com',
                'exp' => time() + 3600,
                'email' => 'frontend@example.com',
                'sub' => 'google-sub-frontend',
                'name' => 'Frontend User',
                'email_verified' => true,
            ], 200),
        ]);

        $response = $this->postJson('/api/login/google', [
            'credential' => 'frontend-google-credential',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user', 'token'])
            ->assertJsonPath('user.email', 'frontend@example.com');

        $this->assertDatabaseHas('users', [
            'email' => 'frontend@example.com',
            'google_id' => 'google-sub-frontend',
        ]);
    }

    public function test_google_login_links_existing_user_by_email()
    {
        $user = User::factory()->create([
            'email' => 'existing@example.com',
            'google_id' => null,
        ]);

        Http::fake([
            'https://oauth2.googleapis.com/tokeninfo*' => Http::response([
                'aud' => config('services.google.client_id'),
                'iss' => 'accounts.google.com',
                'exp' => time() + 3600,
                'email' => 'existing@example.com',
                'sub' => 'google-sub-456',
                'name' => 'Existing User',
                'picture' => 'https://example.com/existing.jpg',
                'email_verified' => 'true',
            ], 200),
        ]);

        $response = $this->postJson('/api/login/google', [
            'id_token' => 'another-dummy-token',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user', 'token'])
            ->assertJsonPath('user.email', 'existing@example.com');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'google_id' => 'google-sub-456',
        ]);
    }

    public function test_google_login_requires_valid_id_token()
    {
        Http::fake([
            'https://oauth2.googleapis.com/tokeninfo*' => Http::response(['error_description' => 'Invalid Value'], 400),
        ]);

        $response = $this->postJson('/api/login/google', [
            'id_token' => 'invalid-token',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('id_token');
    }
}
