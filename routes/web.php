<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\{LoginController, RegisterController, PasswordController};
use App\Http\Controllers\backend\{PostCrudController, UserController};
use App\Http\Controllers\{ProfileController, PostController};

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
    Route::get('/all-user', [UserController::class, 'allUser'])->name('alluser')->middleware('isAdmin');

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



//Old ROutes

// Auth::routes();

// Route::middleware(['auth'])->group(function () {
//

//     //User management
//     Route::get('/all-user', [UserController::class, 'allUser'])->name('alluser')->middleware('isAdmin');
//     Route::get('/add-user-index', [UserController::class, 'addUserIndex'])->name('addUserIndex')->middleware('isAdmin');
//     Route::post('insert-user', [UserController::class, 'insertUser'])->name('insertUser')->middleware('isAdmin');
//     Route::get('/edit-user/{id}', [UserController::class, 'editUser'])->name('editUser')->middleware('isAdmin');
//     Route::post('/update-user/{id}', [UserController::class, 'updateUser'])->name('updateUser')->middleware('isAdmin');
//     Route::get('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('deleteUser')->middleware('isAdmin');

//     // Post management
//     Route::get('/all-post', [PostCrudController::class, 'allPost'])->name('allPost')->middleware('isAdmin');
//     Route::get('/add-post-index', [PostCrudController::class, 'addPostIndex'])->name('addPostIndex');
//     Route::post('insert-post', [PostCrudController::class, 'insertPost'])->name('insertPost');
//     Route::get('/edit-post/{id}', [PostCrudController::class, 'editPost'])->name('editPost');
//     Route::put('/update-post/{id}', [PostCrudController::class, 'updatePost'])->name('updatePost');
//     Route::get('/delete-post/{id}', [PostCrudController::class, 'deletePost'])->name('deletePost');
//     Route::get('/view-post/{id}', [PostCrudController::class, 'viewPost'])->name('viewPost');

//     //Owner Posts
//     Route::get('/my-posts', [PostController::class, 'myPosts'])->name('myPosts');
//     Route::get('/all-user-posts', [PostController::class, 'allUserPosts'])->name('allUserPosts');
//     Route::get('/my-posts/view/{id}', [PostController::class, 'viewPost'])->name('user.viewPost');
//     Route::get('/my-posts/add', [PostController::class, 'addPostIndex'])->name('user.addPost');
//     Route::post('/my-posts/add', [PostController::class, 'insertPost'])->name('user.insertPost');
//     Route::get('/my-posts/edit/{id}', [PostController::class, 'editPost'])->name('user.editPost');
//     Route::put('/my-posts/update/{id}', [PostController::class, 'updatePost'])->name('user.updatePost');
//     Route::get('/my-posts/delete/{id}', [PostController::class, 'deletePost'])->name('user.deletePost');
//     //Profile
//     Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
//     Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

//     Route::delete('profile', [ProfileController::class, 'delete'])->name('profile.delete');

//     Route::post('admin/logout', [App\Http\Controllers\Authentication\Admin\LoginController::class, 'logout'])->name('logout');
//     Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// });


// Route::middleware('guest')->group(function () {
//     // Admin Registration
//     Route::get('/admin/login', [App\Http\Controllers\Authentication\Admin\LoginController::class, 'showLogin'])->name('admin.login.page');
//     Route::post('/admin/login', [App\Http\Controllers\Authentication\Admin\LoginController::class, 'login'])->name('admin.login');


//     //User Registration
//     Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
//     Route::post('/login', [LoginController::class, 'login']);

//     Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
//     Route::post('/register', [RegisterController::class, 'register']);
//     Route::get('/reset', [PasswordController::class, 'showForgotPasswordForm'])->name('password.request');
//     Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])->name('password.email');
//     Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.update');
// });




