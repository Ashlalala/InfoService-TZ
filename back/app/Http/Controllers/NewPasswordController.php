<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Validation\ValidationException;

use function Laravel\Prompts\password;

class NewPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {

        $status = Password::sendResetLink([
            'email' => $request->user()->email
        ]);

        if($status == Password::RESET_LINK_SENT){
            return [
                'status' => __($status)
            ];
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)]
        ]);
    }

    public function reset(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60)
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if($status == Password::PASSWORD_RESET){
            return response([
                'message' => 'Password reset successfully'
            ]);
        }

        return response([
            'message' => __($status)
        ], 500);
    }
}
