<?php

namespace boscowu\TraceLog;

use Illuminate\Support\ServiceProvider;

class TraceLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/tracelog.php' => base_path('config/tracelog.php'),
        ]);
    }
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tracelog.php', 'tracelog');
        $this->app->singleton('TraceLog', function () {
            return new TraceLog();
        });
    }
}
