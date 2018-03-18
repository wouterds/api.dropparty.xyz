<?php

namespace WouterDeSchuyter\DropParty\Domain\Files;

use JsonSerializable;
use Mimey\MimeTypes;
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
     * @param array $data
     * @return File
     */
    public static function fromArray(array $data): File
    {
        $file = new File(
            new UserId($data['user_id']),
            $data['name'],
            $data['content_type'],
            $data['size'],
            $data['md5']
        );

        $file->id = new FileId(!empty($data['id']) ? $data['id'] : null);

        return $file;
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
     * @return string
     */
    public function getExtension(): string
    {
        // Content type helper
        $mimes = new MimeTypes;

        // Try to get extension by filename
        $ext = pathinfo($this->getName(), PATHINFO_EXTENSION);

        // No content type found?
        if (empty($mimes->getMimeType($ext))) {
            // Try to get extension by content type
            $ext = $mimes->getExtension($this->getContentType());
        }

        // No extension found?
        if (empty($ext)) {
            // Fallback to bin
            $ext = 'bin';
        }

        return $ext;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return "/{$this->getId()}.{$this->getExtension()}";
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = get_object_vars($this);
        $data['path'] = $this->getPath();
        $data['extension'] = $this->getExtension();

        return $data;
    }
}
