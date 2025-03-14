<?php

namespace App\Interfaces;

use App\Http\Requests\RegisterRequest;

interface AuthRepositoryInterface
{
    public function register(array $data);
    // public function login(array $credentials);
    // public function logout($user);
}
