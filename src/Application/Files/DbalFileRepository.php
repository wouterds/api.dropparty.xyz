<?php

namespace WouterDeSchuyter\DropParty\Application\Files;

use Doctrine\DBAL\Connection;
use WouterDeSchuyter\DropParty\Domain\Files\FileRepository;

class DbalFileRepository implements FileRepository
{
    public const TABLE = 'file';

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
}
