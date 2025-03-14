<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request){

        try{
            $validated = $request->validated();

            $email = $validated['email'];
            $password = $validated['password'];

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'email & password do not match.',
                ], 401);
            }

            $user = User::where('email', $email)->first();

            return response()->json([
                'status' => true,
                'message' => 'logged in successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
