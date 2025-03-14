<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function index(){
        return view("auth.register");
    }

    public function createUser(RegisterRequest $request){

        try{
            $validated = $request->validated();

            $email = $validated['email'];
            $password = $validated['password'];
            $name = $validated['name'];
            $phone = $validated['phone'];

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make($password)
            ]);

            $token=$user->createToken("API TOKEN")->plainTextToken;

            // return response()->json([
            //     'status' => true,
            //     'message' => 'User Created Successfully',
            //     'token' => $token
            // ], 200);    

        }catch(\Throwable $th){

            // return response()->json([
            //     'status' => false,
            //     'message' => $th->getMessage()
            // ], 500);
            return redirect()->back()->withErrors(['error' => $th->getMessage()])->withInput();
        }
    }
}
