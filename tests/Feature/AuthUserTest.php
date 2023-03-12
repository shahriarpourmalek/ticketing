<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    /**
     * Test that a user can register successfully.
     *
     * @return void
     */
    /** @test  */
    public function test_users_can_be_registered()
    {
        $userData = [
            'name' => fake()->name,
            'email' => fake()->safeEmail(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->json('POST', '/api/register', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'user',
                'message',
            ]);
    }

    /**
     * Test that a user can log in successfully.
     *
     * @return void
     */
    /** @test  */

    public function a_can_be_logined()
    {
        $password = 'password';
        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $userData = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->json('POST', '/api/login', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'user',
                'message',
            ]);
    }

    /**
     * Test that a user can log out successfully.
     *
     * @return void
     */
    /** @test  */

    public function a_user_can_be_loged_out()
    {
        $user = User::factory()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->actingAs($user)->json('POST', '/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Logout successful',
            ]);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'token' => hash('sha256', $token),
        ]);
    }

}
