<?php

namespace App\Http\Controllers\auth;

use App\DTOs\CreateUserDTO;
use App\DTOs\LoginUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(CreateUserRequest $request): JsonResponse
    {
        $user = User::create((new CreateUserDTO($request->validated()))->toArray());

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
            'message' => 'Registration successful'
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = new LoginUserDTO($request->validated());
        $user = User::where('email', $data->email)->first();

        if (!$user || !Hash::check($data->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
            'message' => 'Login successful'
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }
}
