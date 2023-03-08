<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Contracts\Repositories\UserRepositoryContract::class, \App\Repositories\Eloquent\UserRepository::class);
        $this->app->bind(\App\Contracts\Repositories\QuestionRepositoryContract::class, \App\Repositories\Eloquent\QuestionRepository::class);
        $this->app->bind(\App\Contracts\Repositories\ApplicationRepositoryContract::class, \App\Repositories\Eloquent\ApplicationRepository::class);
        $this->app->bind(\App\Contracts\Repositories\AdminRepositoryContract::class, \App\Repositories\Eloquent\AdminRepository::class);
        $this->app->bind(\App\Contracts\Repositories\GiftRepositoryContract::class, \App\Repositories\Eloquent\GiftRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
