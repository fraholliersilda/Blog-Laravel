<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\User;
use App\Models\Media;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    Gate::define('update-post', function (User $user, Post $post) {
        $media = $post->media()->where('user_id', $user->id)->first();
        return $media || $user->isAdmin();
    });

    Gate::define('delete-post', function (User $user, Post $post) {
        $media = $post->media()->where('user_id', $user->id)->first();
        return $media || $user->isAdmin();
    });
}

}
