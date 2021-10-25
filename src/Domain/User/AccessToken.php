<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\User;

use PhpChallenge\Common\Object\StringValue;

final class AccessToken extends StringValue
{
    public static function createToken(): self
    {
        return new self(password_hash(bin2hex(random_bytes(10)), PASSWORD_DEFAULT));
    }
}
