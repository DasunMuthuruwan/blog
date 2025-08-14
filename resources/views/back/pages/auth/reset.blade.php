@extends('back.layout.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div class="login-box bg-white box-shadow border-radius-10">
        <div class="login-title">
            <h2 class="text-center text-primary">Reset Password</h2>
        </div>
        <h6 class="mb-20">Enter your new password, confirm and submit</h6>
        <form action="{{ route('admin.reset_password') }}" method="POST">
            <x-form-alerts />
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="input-group custom mb-1">
                <input type="password" class="form-control form-control-lg" placeholder="New Password" name="password">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
            </div>
            @error('password')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
            <div class="input-group custom mt-2">
                <input type="password" class="form-control form-control-lg" placeholder="Confirm New Password"
                    name="password_confirmation">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
            </div>
            @error('password_confirmation')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="input-group mb-0">
                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
