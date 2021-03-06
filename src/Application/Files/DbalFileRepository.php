<?php

namespace WouterDeSchuyter\DropParty\Application\Files;

use Doctrine\DBAL\Connection;
use WouterDeSchuyter\DropParty\Domain\Files\File;
use WouterDeSchuyter\DropParty\Domain\Files\FileId;
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

    /**
     * @param File $file
     */
    public function add(File $file)
    {
        $query = $this->connection->createQueryBuilder();

        $query->insert(self::TABLE);
        $query->setValue('id', $query->createNamedParameter($file->getId()));
        $query->setValue('user_id', $query->createNamedParameter($file->getUserId()));
        $query->setValue('name', $query->createNamedParameter($file->getName()));
        $query->setValue('content_type', $query->createNamedParameter($file->getContentType()));
        $query->setValue('size', $query->createNamedParameter($file->getSize()));
        $query->setValue('md5', $query->createNamedParameter($file->getMd5()));
        $query->execute();
    }

    /**
     * @param FileId $fileId
     * @return null|File
     */
    public function getById(FileId $fileId): ?File
    {
        $query = $this->connection->createQueryBuilder();

        $query->select('*');
        $query->from(self::TABLE);
        $query->where('id = ' . $query->createNamedParameter($fileId));
        $result = $query->execute();

        if ($result->rowCount() === 0) {
            return null;
        }

        return File::fromArray($result->fetch());
    }
}
