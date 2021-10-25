<?php

declare(strict_types=1);

namespace PhpChallenge\Common\Data;

trait DataFilterTrait
{
    /** @return mixed[] */
    public function filter(string ...$properties): array
    {
        $data = [];
        foreach (array_keys(get_object_vars($this)) as $prop) {
            if (!in_array($prop, $properties)) {
                continue;
            }
            $data[$prop] = $this->$prop;
        }

        return $data;
    }
}
