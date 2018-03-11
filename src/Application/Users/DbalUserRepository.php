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

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function add(User $user): void
    {
        // TODO: Implement add() method.
    }
}
