<?php

namespace Hamedov\Favorites;

use Illuminate\Support\ServiceProvider;

class FavoritesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/favorites.php', 'favorites');
        Favorites::setUserModel(config('favorites.user_model'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/favorites.php' => config_path('favorites.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
