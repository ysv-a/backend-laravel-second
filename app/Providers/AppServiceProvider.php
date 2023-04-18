<?php

namespace App\Providers;

use App\Services\Sms\SmsApi;
use App\Services\Sms\SmsSender;
use Illuminate\Support\ServiceProvider;
use App\Services\Dispatchering\MultiDispatcher;
use Illuminate\Contracts\Foundation\Application;
use App\Services\Dispatchering\LaravelMultiDispatcher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SmsSender::class, function (Application $app) {
            return new SmsApi();
        });

        $this->app->bind(MultiDispatcher::class, LaravelMultiDispatcher::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
