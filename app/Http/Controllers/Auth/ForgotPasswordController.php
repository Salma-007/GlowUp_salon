<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\PasswordResetEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{

    public function showLinkRequestForm()
    {
        return view('auth.recoverpw'); 
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['error' => __($status)], 400);
    }

    public function sendVerificationCode(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // return response()->json(['error' => 'Utilisateur introuvable.'], 404);
            return redirect()->back()->withErrors(['error' => 'Utilisateur introuvable.']);
        }

        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('password_reset_code_' . $user->id, $verificationCode, now()->addMinutes(10));

        Mail::to($user->email)->send(new PasswordResetEmail($verificationCode));

        // return response()->json(['message' => 'Code de vérification envoyé.'], 200);
        return redirect()->route('password.resetToken');
    }
}