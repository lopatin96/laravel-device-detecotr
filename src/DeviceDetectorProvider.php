<?php

namespace Atin\LaravelDeviceDetector;

use Atin\LaravelDeviceDetector\Providers\EventServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Registered;
use hisorange\BrowserDetect\Facade as Browser;

class DeviceDetectorProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        \Event::listen(Registered::class, static function ($event) {
            $event->user->forceFill([
                'device' => Browser::deviceType(),
            ])->save();
        });

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('/migrations')
        ], 'laravel-lang-switcher-migrations');
    }
}