<?php

namespace WouterDeSchuyter\DropParty\Application\Users;

use Doctrine\DBAL\Connection;
use WouterDeSchuyter\DropParty\Domain\Users\User;
use WouterDeSchuyter\DropParty\Domain\Users\UserRepository;

class DbalUserRepository implements UserRepository
{
    public const TABLE = 'user';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param User $user
     */
    public function add(User $user): void
    {
        $query = $this->connection->createQueryBuilder();

        $query->insert(self::TABLE);
        $query->setValue('id', $query->createNamedParameter($user->getId()));
        $query->setValue('dropbox_account_id', $query->createNamedParameter($user->getDropboxAccountId()));
        $query->setValue('dropbox_access_token', $query->createNamedParameter($user->getDropboxAccessToken()));
        $query->setValue('email', $query->createNamedParameter($user->getEmail()));
        $query->setValue('first_name', $query->createNamedParameter($user->getFirstName()));
        $query->setValue('name', $query->createNamedParameter($user->getName()));
        $query->execute();
    }

    /**
     * @param string $dropboxAccountId
     * @return User|null
     */
    public function getByDropboxAccountId(string $dropboxAccountId): ?User
    {
        $query = $this->connection->createQueryBuilder();

        $query->select('*');
        $query->from(self::TABLE);
        $query->where('dropbox_account_id = ' . $query->createNamedParameter($dropboxAccountId));
        $result = $query->execute();

        if ($result->rowCount() === 0) {
            return null;
        }

        return User::fromArray($result->fetch());
    }
}
