<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Role;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define("allowed-user", [ UserPolicy::class, "viewAny" ]);
        Gate::define("allowed-role", [ RolePolicy::class, "viewAny" ]);
        
        Gate::define("allowed-user-update", [ UserPolicy::class, "update" ]);
        Gate::define("allowed-user-delete", [ UserPolicy::class, "delete" ]);
        
        Gate::define("allowed-role-create", [ RolePolicy::class, "create" ]);
        Gate::define("allowed-role-update", [ RolePolicy::class, "update" ]);
        Gate::define("allowed-role-delete", [ RolePolicy::class, "delete" ]);
    }
}
