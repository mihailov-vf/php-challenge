<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\User\Service;

use DomainException;
use PhpChallenge\Domain\User\Data\CreatedUserData;
use PhpChallenge\Domain\User\Data\CreateNewUserData;
use PhpChallenge\Domain\User\User;
use PhpChallenge\Domain\User\UserRepository;

class CreateUser
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function execute(CreateNewUserData $userData): CreatedUserData
    {
        if ($this->userRepository->checkUserEmailExists($userData->email)) {
            throw new DomainException('User already exists');
        }
        $userData->password = password_hash($userData->password, PASSWORD_DEFAULT);
        $user = User::createNewFromData($userData);
        $this->userRepository->createUser($user);

        return $user->toData();
    }
}
