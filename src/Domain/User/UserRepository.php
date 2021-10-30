<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\User;

interface UserRepository
{
    public function createUser(User $user): void;
    public function findUser(string $id): ?User;
    public function checkUserEmailExists(string $email): bool;
}
