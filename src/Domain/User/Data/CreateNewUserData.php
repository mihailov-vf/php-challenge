<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\User\Data;

use PhpChallenge\Common\Data\Data;

/**
 * @codeCoverageIgnore
 */
class CreateNewUserData extends Data
{
    public ?string $id;
    public string $email;
    public string $name;
    public string $password;
}
