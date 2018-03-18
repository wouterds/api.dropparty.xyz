<?php

namespace WouterDeSchuyter\DropParty\Application;

use League\Container\Container as LeagueContainer;
use League\Container\ReflectionContainer;
use WouterDeSchuyter\DropParty\Application\Files\ServiceProvider as FilesServiceProvider;
use WouterDeSchuyter\DropParty\Application\Http\ServiceProvider as HttpServiceProvider;
use WouterDeSchuyter\DropParty\Application\Oauth\ServiceProvider as OauthServiceProvider;
use WouterDeSchuyter\DropParty\Application\Users\ServiceProvider as UsersServiceProvider;
use WouterDeSchuyter\DropParty\Infrastructure\Database\ServiceProvider as DatabaseServiceProvider;

class Container extends LeagueContainer
{
    /**
     * @return Container
     */
    public static function load(): Container
    {
        $container = new static();
        $container->delegate(new ReflectionContainer());

        $container->addServiceProvider(FilesServiceProvider::class);
        $container->addServiceProvider(HttpServiceProvider::class);
        $container->addServiceProvider(OauthServiceProvider::class);
        $container->addServiceProvider(UsersServiceProvider::class);
        $container->addServiceProvider(DatabaseServiceProvider::class);

        return $container;
    }
}
