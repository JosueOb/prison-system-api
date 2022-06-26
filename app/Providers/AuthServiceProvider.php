<?php

namespace App\Providers;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        Gate::define('manage-directors', function (User $user) {
            return $user->role->slug === RoleEnum::ADMIN->value;
        });

        Gate::define('manage-guards', function (User $user) {
            return $user->role->slug === RoleEnum::ADMIN->value;
        });

        Gate::define('manage-prisoners', function (User $user) {
            return $user->role->slug === RoleEnum::ADMIN->value;
        });
    }
}
