<?php

namespace Masterix21\WebsocketsDatabase\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Masterix21\WebsocketsDatabase\WebsocketsDatabaseServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Masterix21\\WebsocketsDatabase\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            WebsocketsDatabaseServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        include_once __DIR__.'/../database/migrations/create_apps_tables.php.stub';
        (new \CreateAppsTable())->up();
    }
}
