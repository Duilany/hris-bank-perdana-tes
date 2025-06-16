<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate untuk role HC (Superadmin/HR)
        Gate::define('isHC', function (User $user) {
            return $user->role === 'hc';
        });

        // Kamu bisa tambahkan gate tambahan di sini jika perlu
        Gate::define('isDireksi', fn (User $user) => $user->role === 'direksi');
        Gate::define('isManajer', fn (User $user) => $user->role === 'manajer');
        Gate::define('isStafSupport', fn (User $user) => $user->role === 'staf_support');
        Gate::define('isStafBisnis', fn (User $user) => $user->role === 'staf_bisnis');
    }
}
