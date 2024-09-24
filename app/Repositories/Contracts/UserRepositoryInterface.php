<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function register(array $data);
    public function login(array $credentials);
    public function logout();
    public function refreshToken();
}
