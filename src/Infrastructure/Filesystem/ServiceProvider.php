<?php

namespace WouterDeSchuyter\DropParty\Infrastructure\Filesystem;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;
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

            $dropboxClient = new DropboxClient(
                $authenticatedUser->getUser()->getDropboxAccessToken(),
                null,
                getenv('DROPBOX_MAX_UPLOAD_CHUNK_SIZE_MB') * pow(1024, 2)
            );

            $dropboxAdapter = new DropboxAdapter($dropboxClient);

            return new Filesystem($dropboxAdapter);
        });
    }
}
