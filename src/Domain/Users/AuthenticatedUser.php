<?php

namespace WouterDeSchuyter\DropParty\Domain\Users;

class AuthenticatedUser
{
    /**
     * @var null|string
     */
    private $token;

    /**
     * @var null|User
     */
    private $user;

    /**
     * @param string|null $token
     * @param User|null $user
     */
    public function __construct(string $token = null, User $user = null)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * @return null|string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param null|string $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param null|User $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
