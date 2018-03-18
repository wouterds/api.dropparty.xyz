<?php

namespace WouterDeSchuyter\DropParty\Domain\Files;

interface FileRepository
{
    /**
     * @param File $file
     */
    public function add(File $file);
}
