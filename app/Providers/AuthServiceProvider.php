<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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

        Passport::tokensExpireIn(now()->addSecond(60));
        Passport::tokensCan([
            'create-post' => 'Create a new post',
            'read-post'   => 'Read a post',
            'update-post' => 'Update a post',
            'delete-post' => 'Delete a post'
        ]);

        Passport::setDefaultScope([
            'read-post',
        ]);
    }
}
