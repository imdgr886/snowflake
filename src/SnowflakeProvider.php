<?php

namespace Imdgr886\Snowflake;

use Illuminate\Support\ServiceProvider;

class SnowflakeProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('snowflake', function () {

            $snowflake = new Snowflake(
                config('snowflake.start_time', '2021-01-01 00:00:00'),
                config('snowflake.datacenter', 0),
                config('snowflake.datacenter_length', 1),
                config('snowflake.sequence_length', 12)
            );
            if (config('snowflake.resolver.class')) {
                $snowflake->setResolver(config('snowflake.resolver.class'));
            }

            return $snowflake;
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/snowflake.php' => config_path('snowflake.php')], 'snowflake');
            $this->commands([
                Command::class,
            ]);
        }
    }
}
