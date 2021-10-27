<?php

declare(strict_types=1);

namespace PhpChallenge\Infra\Auth;

use Mezzio\Authentication\UserInterface;
use PhpChallenge\Domain\User\User;

class AuthUserAdapter extends User implements UserInterface
{
    private $details = [];

    public function getIdentity(): string
    {
        return (string)$this->getId();
    }

    public function getRoles(): iterable
    {
        return $this->roles;
    }

    public function getDetail(string $name, $default = null)
    {
        return $this->getDetails()[$name] ?? $default;
    }

    public function getDetails(): array
    {
        if ($this->details === []) {
            $this->details = [
                'name' => $this->getName(),
                'email' => $this->getEmail(),
            ];
        }

        return $this->details;
    }
}
