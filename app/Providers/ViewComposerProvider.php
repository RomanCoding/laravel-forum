<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view) {
            return $view->with([
                'auth' => auth()->user(),
                'channels' => \App\Channel::all()
            ]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
