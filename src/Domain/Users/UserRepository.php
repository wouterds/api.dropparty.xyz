<?php

namespace WouterDeSchuyter\DropParty\Domain\Users;

interface UserRepository
{
    /**
     * @param User $user
     */
    public function add(User $user): void;
}
