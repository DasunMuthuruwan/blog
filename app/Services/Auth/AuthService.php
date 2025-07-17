<?php

namespace App\Services\Auth;

use App\Exceptions\PasswordIncorrectException;
use App\Exceptions\UserCurrentlyInactiveException;
use App\Exceptions\UserCurrentlyPendingStatusException;
use App\UserStatus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(object $loginRequest): string
    {
        if (Auth::attempt([
            $loginRequest->login_type => $loginRequest->login_id,
            'password' => $loginRequest->password
        ])) {
            $authUser = auth()->user();
            if ($authUser->status == UserStatus::Inactive) {
                Auth::logout();
                $loginRequest->session()->invalidate();
                $loginRequest->session()->regenerateToken();

                throw new UserCurrentlyInactiveException('Your account is currently incative. Please, contact support as (support@larablog.test) for further assistance.');
            }

            if ($authUser->status == UserStatus::Pending) {
                Auth::logout();
                $loginRequest->session()->invalidate();
                $loginRequest->session()->regenerateToken();

                throw new UserCurrentlyPendingStatusException("Your account is currently pending approval. Please, check your email for further instructions or contact support at (supper@larablog.test) for further assistance.");
            }

            $authUser->update([
                'last_login' => Carbon::now()
            ]);

            return "User logged in successfully.";
        }

        throw new PasswordIncorrectException("Incorrect password.");
    }
}
