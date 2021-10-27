<?php

declare(strict_types=1);

namespace PhpChallenge\Infra\Auth;

class AuthUserFactory
{
    public function __invoke()
    {
        return function ($id, $roles, $details) {
            return new AuthUserAdapter($id, $details['email'], $details['name'], $details['password'], $roles);
        };
    }
}
