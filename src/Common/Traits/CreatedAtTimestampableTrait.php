<?php

declare(strict_types=1);

namespace PhpChallenge\Common\Traits;

use DateTimeImmutable;

trait CreatedAtTimestampableTrait
{
    protected DateTimeImmutable $createdAt;

    /**
     * @codeCoverageIgnore
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
