<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\{LoginController, RegisterController, PasswordController};
use App\Http\Controllers\{HomeController, UserController, ProfileController, LanguageController, ApiKeyController, PayPalController, PostController, CommentController};

Route::get('/', function () {
    return view('welcome');
});

//Api Key purchased using paypal
Route::get('/api-keys/purchase', [ApiKeyController::class, 'showPurchasePage'])->name('api-keys.purchase');
Route::get('/api-keys/purchase/success', [ApiKeyController::class, 'showPurchaseSuccess'])->name('api-keys.purchase.success');

// PayPal Routes
Route::post('/paypal/process', [PayPalController::class, 'processPayment'])->name('paypal.process');
Route::get('/paypal/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.cancel');

Route::middleware(['guest'])->group(function () {
    // Admin Registration
    Route::get('/admin/login', [App\Http\Controllers\Authentication\Admin\LoginController::class, 'showLogin'])->name('admin.login.page');
    Route::post('/admin/login', [App\Http\Controllers\Authentication\Admin\LoginController::class, 'login'])->name('admin.login');


    //User Registration
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    //Reset password
    Route::get('/forgot-password', [PasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.update');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    // Show users
    //User management
    Route::post('/users/import', [UserController::class, 'importUsers'])->name('users.import');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');

    Route::get('/users/data', [UserController::class, 'getUsers'])->name('users.data');
    Route::get('/all-users', [UserController::class, 'index'])->name('users.index');
    Route::post('/insert-user', [UserController::class, 'insertUser'])->name('insertUser');
    Route::put('/update-user/{id}', [UserController::class, 'updateUser'])->name('updateUser');
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');

    Route::get('/admin/home', [HomeController::class, 'adminDashboard'])->name('admin.home');

    //api keys
    Route::resource('api-keys', ApiKeyController::class)->only([
        'index',
        'store',
        'destroy'
    ]);

    Route::get('api-keys/data', [ApiKeyController::class, 'getApiKeys'])->name('api-keys.data');

    //posts
    Route::get('/admin/posts', [PostController::class, 'adminPosts'])->name('admin.posts');
    Route::get('/admin/posts/data', [PostController::class, 'getPosts'])->name('admin.posts.data');

});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'userDashboard'])->name('user.home');

    //Posts
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/my-posts', [PostController::class, 'myPosts'])->name('posts.myPosts');
    Route::get('/posts/others', [PostController::class, 'othersPosts'])->name('posts.others');

    //Comments
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

});

Route::middleware(['auth', 'role:admin|user'])->group(function () {
    // Profile
    // Logout

    //Language switch
    Route::get('language/{lang}', [LanguageController::class, 'switchLang'])->name('language.switch');

    // Profile Management
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.updatePicture');
    Route::delete('profile', [ProfileController::class, 'delete'])->name('profile.delete');
    //Posts
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    // Logout
    Route::post('admin/logout', [App\Http\Controllers\Authentication\Admin\LoginController::class, 'logout'])->name('logout');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

