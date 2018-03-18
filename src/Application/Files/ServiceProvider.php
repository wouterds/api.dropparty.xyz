<?php

namespace WouterDeSchuyter\DropParty\Application\Files;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WouterDeSchuyter\DropParty\Domain\Files\FileRepository;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        FileRepository::class,
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->container->share(FileRepository::class, function () {
            return $this->container->get(DbalFileRepository::class);
        });
    }
}
