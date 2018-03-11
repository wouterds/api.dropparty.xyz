<?php

namespace WouterDeSchuyter\DropParty\Application\Domain\Users;

interface UserRepository
{
    /**
     * @param User $user
     */
    public function add(User $user): void;
}
