<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Repositories\Contracts\UserRepositoryInterface;

class AuthController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function register(RegistrationRequest $request)
    {
        $validated = $request->validated();

        try {
            $token = $this->userRepository->register($validated);
            return response()->json(["message" => "Registration Successfully complete", 'token' => $token], 201);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 401);
        }
    }


    public function login(LoginRequest $request)
    {
        $request->validated();
        
        try {
            $credentials = $request->only('email', 'password');
            $token = $this->userRepository->login($credentials);

            if (!$token) {
                return response()->json(['error' => 'Invalid email or password.'], 401);
            }
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 409);
        }

        return response()->json(["message" => "Login Success", 'token' => $token],201);
    }


    public function logout()
    {
        try {
            $this->userRepository->logout();
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 401);
        }
        return response()->json(['message' => 'Successfully logged out'],201);
    }

    public function refresh()
    {
        try {
            $newToken = $this->userRepository->refreshToken();
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 401);
        }
        return response()->json(['token' => $newToken], 201);
    }
}
