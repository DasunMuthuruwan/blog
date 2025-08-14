<?php

namespace App\Http\Controllers;

use App\Exceptions\PasswordIncorrectException;
use App\Exceptions\UserCurrentlyInactiveException;
use App\Exceptions\UserCurrentlyPendingStatusException;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Notifications\PasswordResetSuccessNotification;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $serverError;

    public function __construct()
    {
        $this->serverError = config('exception-errors.errors.server-error');
    }

    public function registerForm(Request $request)
    {
        return view('back.pages.auth.register', [
            'pageTitle' => 'Register'
        ]);
    }

    public function loginForm(Request $request)
    {
        return view('back.pages.auth.login', [
            'pageTitle' => 'Login'
        ]);
    }

    public function forgotForm()
    {
        return view('back.pages.auth.forgot', [
            'pageTitle' => 'Forgot Password'
        ]);
    }

    public function loginHandler(LoginRequest $request)
    {
        try {
            (new AuthService)->login($request);

            return redirect()->route('admin.dashboard');
        } catch (
            UserCurrentlyInactiveException |
            UserCurrentlyPendingStatusException $exception
        ) {
            return redirect()->route('admin.login')->withInput()->with('fail', $exception->getMessage());
        } catch (PasswordIncorrectException $exception) {
            return redirect()->route('admin.login')->withInput()->with('fail', $exception->getMessage());
        } catch (Exception $exception) {
            return redirect()->route('admin.login')->withInput()->with('fail', $this->serverError);
        }
    }

    public function sendPasswordResetLink(ForgotPasswordRequest $forgotPasswordRequest)
    {
        try {
            $status = Password::sendResetLink($forgotPasswordRequest->only('email'));

            return $status === Password::ResetLinkSent
                ? redirect()->route('admin.forgot')->withInput()->with('success', "We have e-mailed your password reset link.")
                : redirect()->route('admin.forgot')->withInput()->with('fail', "Sommething went wrong. Resetting password link not sent. Try again later.");
        } catch (Exception $exception) {
            return redirect()->route('admin.forgot')->withInput()->with('fail', $this->serverError);
        }
    }

    public function resetForm(Request $request)
    {
        try {

            return view('back.pages.auth.reset', [
                'pageTitle' => 'Reset Password',
                'email' => $request->email,
                'token' => $request->token
            ]);
        } catch (Exception $exception) {
            return redirect()->route('admin.forgot')->with('fail', $this->serverError);
        }
    }

    public function resetPasswordHandler(ResetPasswordRequest $resetPasswordRequest)
    {
        try {

            $status = Password::reset(
                $resetPasswordRequest->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
                    $user->password_changed_at = Carbon::now();
                    $user->save();

                    Notification::send($user, new PasswordResetSuccessNotification($user, $password));
                }
            );

            return $status === Password::PasswordReset
                ? redirect()->route('admin.login')->withInput()->with('success', "Done. Your password has been changed success fully. Use your new password for login into system.")
                : redirect()->route('admin.reset_password_form', [$resetPasswordRequest->token, $resetPasswordRequest->email])->with('fail', "Invalid token. Request another reset password link.");
        } catch (Exception $exception) {
            return redirect()->route('admin.reset_password_form', [$resetPasswordRequest->token, $resetPasswordRequest->email])->withInput()->with('fail', $this->serverError);
        }
    }
}
