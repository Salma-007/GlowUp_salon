<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
    
    public function loginpage(){
        return view("auth.login");
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $user = $this->authRepository->register($validatedData);

            return redirect()->route('loginIn')->with('success', 'Utilisateur crée avec succès !');

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $result = $this->authRepository->login($validatedData);

            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('client')) {
                return redirect()->route('home');
            } else {
                return redirect()->route('admin.dashboard'); 
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
    
    public function logout(Request $request)
    {
        try {
            $this->authRepository->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('loginIn')->with('success', 'Déconnexion réussie !');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
