<?php

declare(strict_types=1);

namespace PhpChallenge\Common\Data;

use DateTimeImmutable;
use PhpChallenge\Common\Data\Caster\DateTimeCaster;
use Spatie\DataTransferObject\Attributes\DefaultCast;
use Spatie\DataTransferObject\DataTransferObject;

#[
    DefaultCast(DateTimeImmutable::class, DateTimeCaster::class)
]
class Data extends DataTransferObject
{
}
