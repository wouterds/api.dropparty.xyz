<?php

namespace WouterDeSchuyter\DropParty\Infrastructure\ValueObjects;

use JsonSerializable;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid as BaseUuid;

class Uuid implements JsonSerializable
{
    /**
     * @var string
     */
    protected $value;

    public function __construct(string $value = null)
    {
        if (!empty($value)) {
            $this->isValid($value);
        }

        if (empty($value)) {
            $value = BaseUuid::uuid4()->toString();
        }

        $this->value = $value;
    }

    public function isValid(string $value): bool
    {
        if (!BaseUuid::isValid($value)) {
            throw new InvalidUuidStringException();
        }

        return true;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
