<?php

namespace WouterDeSchuyter\DropParty\Application;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;
use WouterDeSchuyter\DropParty\Application\Http\ServiceProvider as HttpServiceProvider;

class Container extends LeagueContainer
{
    public static function load(): Container
    {
        $container = new static();
        $container->delegate(new ReflectionContainer());

        $container->addServiceProvider(HttpServiceProvider::class);

        return $container;
    }
}
