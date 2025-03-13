<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{UserApiController, PostApiController};

Route::middleware(['api.key'])->group(function () {
    Route::get('/users', [UserApiController::class, 'index'])->middleware('emailBelongsToAdmin');
    Route::get('/users/{id}', [UserApiController::class, 'show'])->middleware('emailBelongsToAdmin');

    Route::apiResource('posts', PostApiController::class);
});

