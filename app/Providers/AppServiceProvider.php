<?php

namespace App\Providers;

use App\Models\Users;
use App\Models\PostInGroups;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

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
        Paginator::defaultView('pagination::default');

        Gate::define('destroy-post', function (Users $user, PostInGroups $post) {
            return $user->id === $post->user_id;
        });

        Gate::define('edit-post', function (Users $user, PostInGroups $post) {
            return $user->id === $post->user_id;
        });
    }
}
