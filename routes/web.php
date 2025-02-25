<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\{LoginController, RegisterController, PasswordController};
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['guest'])->group(function () {
    // Admin Registration
    Route::get('/admin/login', [App\Http\Controllers\Authentication\Admin\LoginController::class, 'showLogin'])->name('admin.login.page');
    Route::post('/admin/login', [App\Http\Controllers\Authentication\Admin\LoginController::class, 'login'])->name('admin.login');


    //User Registration
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/reset', [PasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])->name('password.email');
    Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.update');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    // Show users
    //User management
    Route::get('/all-user', [UserController::class, 'allUser'])->name('alluser');

});

Route::middleware(['auth', 'role:user'])->group(function () {
    // Home page with message 'You are logged in'

});

Route::middleware(['auth', 'role:admin|user'])->group(function () {
    // Profile
    // Logout

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Profile Management
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('profile', [ProfileController::class, 'delete'])->name('profile.delete');

    // Logout
    Route::post('admin/logout', [App\Http\Controllers\Authentication\Admin\LoginController::class, 'logout'])->name('logout');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
