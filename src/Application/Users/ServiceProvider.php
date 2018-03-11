<?php

namespace WouterDeSchuyter\DropParty\Application\Users;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WouterDeSchuyter\DropParty\Domain\Users\UserRepository;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        UserRepository::class,
    ];

    public function register()
    {
        $this->container->share(UserRepository::class, function () {
            return $this->container->get(DbalUserRepository::class);
        });
    }
}
