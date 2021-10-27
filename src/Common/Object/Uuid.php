<?php

declare(strict_types=1);

namespace PhpChallenge\Common\Object;

use InvalidArgumentException;

final class Uuid extends StringValue
{
    public static function createUuidString(): string
    {
        return uuid_create(UUID_TYPE_RANDOM);
    }

    public function __construct(private ?string $value = null)
    {
        if (!$value) {
            $value = self::createUuidString();
        }
        if (!uuid_is_valid($value)) {
            throw new InvalidArgumentException('Invalid UUID value');
        }
        parent::__construct($value);
    }
}
