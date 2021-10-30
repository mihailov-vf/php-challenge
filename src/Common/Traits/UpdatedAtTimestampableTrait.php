<?php

declare(strict_types=1);

namespace PhpChallenge\Common\Traits;

use DateTimeImmutable;

trait UpdatedAtTimestampableTrait
{
    protected DateTimeImmutable $updatedAt;

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
