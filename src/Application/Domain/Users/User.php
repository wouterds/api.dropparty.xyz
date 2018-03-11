<?php

namespace WouterDeSchuyter\DropParty\Application\Domain\Users;

use JsonSerializable;

class User implements JsonSerializable
{
    private const PROTECTED_PROPS = [
    ];

    /**
     * @var UserId
     */
    private $id;

    /**
     * @var string
     */
    private $dropboxId;

    /**
     * @var string
     */
    private $dropboxAccessToken;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @param string $dropboxId
     * @param string $dropboxAccessToken
     * @param string $email
     * @param string|null $firstName
     * @param string|null $name
     */
    public function __construct(
        string $dropboxId,
        string $dropboxAccessToken,
        string $email,
        string $firstName = null,
        string $name = null
    ) {
        $this->id = new UserId();

        if (empty($firstName)) {
            $firstName = null;
        }

        if (empty($name)) {
            $name = null;
        }

        $this->dropboxId = $dropboxId;
        $this->dropboxAccessToken = $dropboxAccessToken;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->name = $name;
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDropboxId(): string
    {
        return $this->dropboxId;
    }

    /**
     * @return string
     */
    public function getDropboxAccessToken(): string
    {
        return $this->dropboxAccessToken;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $props = get_object_vars($this);

        foreach (self::PROTECTED_PROPS as $prop) {
            if (isset($props[$prop])) {
                unset($props[$prop]);
            }
        }

        return $props;
    }
}
