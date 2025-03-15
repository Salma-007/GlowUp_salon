<?php

namespace App\Http\Controllers\Auth;

use Str;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{

    public function showValideToken()
    {
        return view('auth.confirm-mail'); 
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['error' => __($status)], 400);
    }

    public function validateResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // return response()->json(['error' => 'Utilisateur introuvable.'], 404);
            return redirect()->back()->withErrors(['error' => 'Utilisateur introuvable.']);
        }

        $storedCode = Cache::get('password_reset_code_' . $user->id);

        if ($storedCode && $storedCode === $request->code) {

            $resetToken = Str::random(60);
            Cache::put('password_reset_token_' . $user->id, $resetToken, now()->addMinutes(10));

            // return response()->json(['message' => 'Code valide.', 'reset_token' => $resetToken], 200);
            return redirect()->route('password.reset', ['token' => $resetToken]);
            
        }

        // return response()->json(['error' => 'Code invalide ou expiré.'], 400);
        return redirect()->back()->withErrors(['error' => 'Code invalide ou expiré.']);
    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Utilisateur introuvable.']);
        }

        $storedToken = Cache::get('password_reset_token_' . $user->id);
        if (!$storedToken || $storedToken !== $request->token) {
            return redirect()->back()->withErrors(['error' => 'Utilisateur introuvable.']);
        }

        $user->password = \Hash::make($request->password);
        $user->save();

        Cache::forget('password_reset_token_' . $user->id);

        // return response()->json(['message' => 'Mot de passe réinitialisé avec succès.'], 200);
        return redirect()->route('admin.dashboard');
    }
}