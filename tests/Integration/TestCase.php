<?php

namespace Nopaad\Analytics\Tests\Integration;

use Orchestra\Testbench\TestCase as Orchestra;
use Nopaad\Analytics\AnalyticsFacade;
use Nopaad\Analytics\AnalyticsServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            AnalyticsServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Analytics' => AnalyticsFacade::class,
        ];
    }
}
