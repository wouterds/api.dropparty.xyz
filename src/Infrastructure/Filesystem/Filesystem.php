<?php

namespace WouterDeSchuyter\DropParty\Infrastructure\Filesystem;

use League\Flysystem\Filesystem as LeagueFilesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;
use WouterDeSchuyter\DropParty\Domain\Users\User;

class Filesystem extends LeagueFilesystem
{
    /**
     * @param User $user
     * @return Filesystem
     */
    public static function fromUser(User $user): Filesystem
    {
        $dropboxClient = new DropboxClient(
            $user->getDropboxAccessToken(),
            null,
            getenv('DROPBOX_MAX_UPLOAD_CHUNK_SIZE_MB') * pow(1024, 2)
        );

        $dropboxAdapter = new DropboxAdapter($dropboxClient);

        return new static($dropboxAdapter);
    }
}
