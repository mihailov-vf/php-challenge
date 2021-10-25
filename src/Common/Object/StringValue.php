<?php

declare(strict_types=1);

namespace PhpChallenge\Common\Object;

use Stringable;

class StringValue implements Stringable
{
    public function __construct(private string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
