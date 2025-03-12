<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;

Route::middleware(['api.key'])->group(function () {
    Route::get('/users', [UserApiController::class, 'index']);
    // ->middleware('emailBelongsToAdmin');
    Route::get('/users/{id}', [UserApiController::class, 'show']);
});
