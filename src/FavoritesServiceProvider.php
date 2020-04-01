<?php

namespace Hamedov\Taxonomies;

use Illuminate\Support\ServiceProvider;
use Hamedov\Favorites\Favorites;


class TaxonomyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'favorites');
        Favorites::setUserModel(config('favorites.user_model'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->publishes([
        //     __DIR__.'/../config/config.php' => config_path('favorites.php'),
        // ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
