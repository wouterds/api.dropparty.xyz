<?php

namespace WouterDeSchuyter\DropParty\Domain\Users;

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
    private $dropboxAccountId;

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
     * @param string $dropboxAccountId
     * @param string $dropboxAccessToken
     * @param string $email
     * @param string|null $firstName
     * @param string|null $name
     */
    public function __construct(
        string $dropboxAccountId,
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

        $this->dropboxAccountId = $dropboxAccountId;
        $this->dropboxAccessToken = $dropboxAccessToken;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->name = $name;
    }

    /**
     * @param array $data
     * @return User
     */
    public static function fromArray(array $data): User
    {
        $user = new User(
            $data['dropbox_account_id'],
            $data['dropbox_access_token'],
            $data['email'],
            $data['first_name'],
            $data['name']
        );

        $user->id = new UserId(!empty($data['id']) ? $data['id'] : null);

        return $user;
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
    public function getDropboxAccountId(): string
    {
        return $this->dropboxAccountId;
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
