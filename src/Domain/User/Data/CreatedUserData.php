<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\User\Data;

use DateTimeImmutable;
use PhpChallenge\Common\Data\Data;
use PhpChallenge\Common\Data\DataFilterTrait;

/**
 * @codeCoverageIgnore
 */
class CreatedUserData extends Data
{
    use DataFilterTrait;

    public string $id;
    public string $email;
    public string $name;
    public string $password;
    public string $token;
    public DateTimeImmutable $created_at;
    public bool $enabled;
}
