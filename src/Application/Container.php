<?php

namespace WouterDeSchuyter\DropParty\Application;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;
use WouterDeSchuyter\DropParty\Application\Http\ServiceProvider as HttpServiceProvider;
use WouterDeSchuyter\DropParty\Infrastructure\Database\ServiceProvider as DatabaseServiceProvider;

class Container extends LeagueContainer
{
    public static function load(): Container
    {
        $container = new static();
        $container->delegate(new ReflectionContainer());

        $container->addServiceProvider(HttpServiceProvider::class);
        $container->addServiceProvider(DatabaseServiceProvider::class);

        return $container;
    }
}
