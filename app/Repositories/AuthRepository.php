<?php

namespace App\Repositories;

use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $data)
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password'])
            ]);

            $token = $user->createToken("API TOKEN")->plainTextToken;

            return $user;

        } catch (\Throwable $th) {
            throw new \Exception("Erreur lors de l'enregistrement : " . $th->getMessage());
        }
    }

    public function login(array $data)
    {
        try {
            if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                throw new \Exception('Email & password do not match.');
            }

            $user = User::where('email', $data['email'])->first();
            $token = $user->createToken("API TOKEN")->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

}