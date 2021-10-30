<?php

declare(strict_types=1);

namespace PhpChallenge\Common\Data\Caster;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;
use Spatie\DataTransferObject\Caster;

class DateTimeCaster implements Caster
{
    public function __construct(
        /** @var class-string<DateTimeInterface> */
        private string $type = DateTimeImmutable::class
    ) {
    }

    public function cast(mixed $value): DateTimeInterface
    {
        if ($value instanceof DateTimeInterface) {
            /** @var callable */
            $callable = [$this->type, 'createFromInterface'];
            return call_user_func_array($callable, [$value]);
        }
        if (!is_subclass_of($this->type, DateTimeInterface::class)) throw new InvalidArgumentException('Invalid date Type');
        if (strtotime($value) === false) throw new InvalidArgumentException('Invalid date format');

        return new $this->type($value);
    }
}
