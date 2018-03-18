<?php

namespace WouterDeSchuyter\DropParty\Domain\Files;

interface FileRepository
{
    /**
     * @param File $file
     */
    public function add(File $file);

    /**
     * @param FileId $fileId
     * @return null|File
     */
    public function getById(FileId $fileId): ?File;
}
