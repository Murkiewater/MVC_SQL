<?php

namespace App\Providers;

use App\Models\Users;
use App\Models\Groups;
use App\Models\PostInGroups;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('destroy-post', function (Users $user, PostInGroups $post) {
            return $user->id === $post->user_id;
        });

        Gate::define('edit-post', function (Users $user, PostInGroups $post) {
            return $user->id === $post->user_id;
        });

        Gate::define('create-group', function (Users $user) {
            return true;
        });

        Gate::define('create-user', function (Users $user) {
            return true;
        });
    }
}