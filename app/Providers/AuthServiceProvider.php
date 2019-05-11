<?php

namespace App\Providers;

use App\Models\GoodsCategory;
use App\Observers\GoodsCategoryObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::guessPolicyNamesUsing(function ($class){
            return '\\App\\Policies\\'.class_basename($class).'Policy';
        });
        GoodsCategory::observe(GoodsCategoryObserver::class);

    }

    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub
    }
}
