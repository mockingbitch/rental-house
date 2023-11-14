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
        $repositories = [
            'User\UserRepositoryInterface'          => 'User\UserRepository',
            'User\PasswordResetRepositoryInterface' => 'User\PasswordResetRepository',
            'Category\CategoryRepositoryInterface'  => 'Category\CategoryRepository',
            'Tag\TagRepositoryInterface'            => 'Tag\TagRepository',
            'House\HouseRepositoryInterface'        => 'House\HouseRepository',
        ];

        foreach ($repositories as $key => $value) {
            $this->app->bind("App\\Repositories\\$key", "App\\Repositories\\$value");
        }
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
