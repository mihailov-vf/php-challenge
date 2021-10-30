<?php

declare(strict_types=1);

namespace PhpChallenge\Common\Traits;

trait TimestampableTrait
{
    use CreatedAtTimestampableTrait;
    use UpdatedAtTimestampableTrait;
}
