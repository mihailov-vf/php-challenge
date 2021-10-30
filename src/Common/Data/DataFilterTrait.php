<?php

declare(strict_types=1);

namespace PhpChallenge\Common\Data;

trait DataFilterTrait
{
    /** @return mixed[] */
    public function filter(string ...$properties): array
    {
        return $this->only(...$properties)->toArray();
    }
}
