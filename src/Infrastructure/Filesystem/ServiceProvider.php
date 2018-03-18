<?php

namespace WouterDeSchuyter\DropParty\Infrastructure\Filesystem;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WouterDeSchuyter\DropParty\Domain\Users\AuthenticatedUser;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Filesystem::class,
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->container->share(Filesystem::class, function() {
            $authenticatedUser = $this->container->get(AuthenticatedUser::class);

            return Filesystem::fromUser($authenticatedUser->getUser());
        });
    }
}
