<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\AuthRepositoryInterface;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function index(){
        return view("auth.register");
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $user = $this->authRepository->register($validatedData);

            return redirect()->route('admin.dashboard')->with('success', 'Utilisateur enregistré avec succès !');

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    // public function login(){

    // }


}
