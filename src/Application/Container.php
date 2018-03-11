<?php

namespace WouterDeSchuyter\DropParty\Application;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;

class Container extends LeagueContainer
{
    public static function load(): Container
    {
        $container = new static();
        $container->delegate(new ReflectionContainer());

        //$container->addServiceProvider(Class::class);

        return $container;
    }
}
