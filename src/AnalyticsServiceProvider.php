<?php

namespace Nopaad\Analytics;

use Illuminate\Support\ServiceProvider;
use Nopaad\Analytics\Exceptions\InvalidConfiguration;

class AnalyticsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/google-analytics.php' => config_path('google-analytics.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $analyticsConfig = config('google-analytics');

        $this->app->bind(AnalyticsClient::class, function () use ($analyticsConfig) {
            return AnalyticsClientFactory::createForConfig($analyticsConfig);
        });

        $this->app->bind(Analytics::class, function () use ($analyticsConfig) {
            $this->guardAgainstInvalidConfiguration($analyticsConfig);

            $client = app(AnalyticsClient::class);

            return new Analytics($client, $analyticsConfig['view_id']);
        });

        $this->app->alias(Analytics::class, 'google-analytics');
    }

    /**
     * @param array|null $analyticsConfig
     *
     * @throws \Nopaad\Analytics\Exceptions\InvalidConfiguration
     */
    protected function guardAgainstInvalidConfiguration($analyticsConfig)
    {
        if (empty($analyticsConfig['view_id'])) {
            throw InvalidConfiguration::viewIdNotSpecified();
        }

        if (! file_exists($analyticsConfig['service_account_credentials_json'])) {
            throw InvalidConfiguration::credentialsJsonDoesNotExist($analyticsConfig['service_account_credentials_json']);
        }
    }
}
