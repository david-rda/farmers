<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::personalAccessTokensExpireIn(Carbon::now()->addYears(1));

        // უფლებების განსაზღვრა ავტორიზირებული მომხმარებლისთვის

        Gate::define("delete-user", function($user) {
            return $user->role == 3;
        });

        Gate::define("edit-user", function($user) {
            return $user->role == 3;
        });

        Gate::define("add-user", function($user) {
            return $user->role == 3;
        });

        Gate::define("get-users", function($user) {
            return $user->role == 3;
        });
        
        // უფლებების განსაზღვრა ავტორიზირებული მომხმარებლისთვის
    }
}
