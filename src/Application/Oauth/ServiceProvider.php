<?php

namespace WouterDeSchuyter\DropParty\Application\Oauth;

use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        DropboxOauthProvider::class,
    ];

    public function register()
    {
        $this->container->share(DropboxOauthProvider::class, function () {
            return new DropboxOauthProvider([
                'clientId' => getenv('DROPBOX_CLIENT_ID'),
                'clientSecret' => getenv('DROPBOX_CLIENT_SECRET'),
            ]);
        });
    }
}
