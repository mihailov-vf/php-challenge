<?php

declare(strict_types=1);

namespace PhpChallenge\Common\Object;

abstract class Entity
{
    private Uuid $id;

    public function __construct(string|Uuid $id = null)
    {
        $this->id = $id instanceof Uuid ? $id : new Uuid($id);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
