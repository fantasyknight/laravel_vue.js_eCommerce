<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-resource', function ($user, $resource) {
            if ($user->role_id == 7 || $user->role_id == 8) return true;
            else return $user->id == $resource->author_id;
        });

        Gate::define('vendor-role', function ($user) {
            if ($user->role_id == 4) return true;
            return false;
        });
    }
}
