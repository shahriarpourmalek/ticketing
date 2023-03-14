<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_register_successfully()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson(route('register'), $data);

        $response->assertStatus(201);
    }

    /** @test */
    public function a_user_can_login_successfully()
    {
        $password = 'password';
        $user = User::factory()->create([
            'password' => Hash::make($password)
        ]);

        $data = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_cannot_login_with_invalid_credentials()
    {
        $data = [
            'email' => $this->faker->email,
            'password' => 'password',
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid email or password',
            ]);
    }

    /** @test */
    public function a_user_can_logout_successfully()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->actingAs($user)->postJson(route('logout'), [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Logout successful',
            ]);
    }

    /** @test */
    public function a_guest_cannot_logout()
    {
        $response = $this->postJson(route('logout'));

        $response->assertStatus(401);
    }

}
