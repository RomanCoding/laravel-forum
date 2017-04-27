<?php

namespace App\Providers;

use App\Channel;
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
            $channels = \Cache::rememberForever('channels', function () {
                return Channel::all();
            });
            return $view->with([
                'auth' => auth()->user(),
                'channels' => $channels
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
