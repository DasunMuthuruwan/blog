<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/** 
 * TESTING ROUTES
 */
Route::view('example-page', 'example-page');
Route::view('example-auth', 'example-auth');

/**
 * ADMIN ROUTES
 */

 Route::prefix('admin')->name('admin.')->group(function() {
    Route::middleware(['guest', 'prevent-back-history'])->group(function() {
        Route::controller(AuthController::class)->group(function() {
            Route::get('/login', 'loginForm')->name('login');
            Route::post('/login', 'loginHandler')->name('login_handler');
            Route::get('/forgot-password', 'forgotForm')->name('forgot');
            Route::post('send-password-reset-link', 'sendPasswordResetLink')->name('send_password_reset_link');
            Route::get('/password/reset/{token}','resetForm')->name('reset_password_form');
            Route::post('reset-password', 'resetPasswordHandler')->name('reset_password');
        });
    });

    Route::middleware(['auth', 'prevent-back-history'])->group(function() {
        Route::controller(AdminController::class)->group(function() {
            Route::get('/dashboard', 'adminDashboard')->name('dashboard');
            Route::post('logout', 'logoutHandler')->name('logout');
            Route::get('profile', 'profileView')->name('profile');
            Route::post('/update-profile-picture', 'updateProfilePicture')->name('update_profile_picture');
            Route::get('settings', 'generalSettings')->name('settings');
            Route::post('update-logo', 'updateLogo')->name('update_logo');
            Route::post('update-favicon', 'updateFavicon')->name('update_favicon');
        });

        // categories routes
        Route::controller(CategoryController::class)->group(function() {
            Route::get('/categories', 'index')->name('categories');
        });
    });
 });