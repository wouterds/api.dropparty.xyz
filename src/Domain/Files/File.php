<?php

namespace WouterDeSchuyter\DropParty\Domain\Files;

use JsonSerializable;
use WouterDeSchuyter\DropParty\Domain\Users\UserId;

class File implements JsonSerializable
{
    /**
     * @var FileId
     */
    private $id;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $md5;

    /**
     * @param UserId $userId
     * @param string $name
     * @param string $contentType
     * @param int $size
     * @param string $md5
     */
    public function __construct(UserId $userId, string $name, string $contentType, int $size, string $md5)
    {
        $this->id = new FileId();
        $this->userId = $userId;
        $this->name = $name;
        $this->contentType = $contentType;
        $this->size = $size;
        $this->md5 = $md5;
    }

    /**
     * @return FileId
     */
    public function getId(): FileId
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getMd5(): string
    {
        return $this->md5;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
