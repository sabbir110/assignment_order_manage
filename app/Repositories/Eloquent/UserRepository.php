<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository implements UserRepositoryInterface
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return JWTAuth::fromUser($user);
    }

    public function login(array $credentials)
    {
        return JWTAuth::attempt($credentials);
    }

    public function logout()
    {
        Auth::logout();
    }

    public function refreshToken()
    {
        return JWTAuth::refresh(JWTAuth::getToken());
    }
}
