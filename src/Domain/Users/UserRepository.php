<?php

namespace WouterDeSchuyter\DropParty\Domain\Users;

interface UserRepository
{
    /**
     * @param User $user
     */
    public function add(User $user): void;

    /**
     * @param string $dropboxAccountId
     * @return User
     */
    public function getByDropboxAccountId(string $dropboxAccountId): User;
}
