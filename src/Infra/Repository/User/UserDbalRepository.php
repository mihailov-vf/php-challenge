<?php

declare(strict_types=1);

namespace PhpChallenge\Infra\Repository\User;

use Doctrine\DBAL\Connection;
use PhpChallenge\Domain\User\Data\CreatedUserData;
use PhpChallenge\Domain\User\User;
use PhpChallenge\Domain\User\UserRepository;

class UserDbalRepository implements UserRepository
{
    private string $table = 'users';

    public function __construct(private Connection $connection)
    {
    }

    public function createUser(User $user): void
    {
        $this->connection->insert(
            $this->table,
            (array)$user->toData(),
            [
                'created_at' => 'datetimetz_immutable',
                'enabled' => 'boolean',
            ]
        );
    }

    public function findUser(string $id): User
    {
        $data = $this->connection->createQueryBuilder()
            ->select()
            ->from($this->table)
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchOne();

        return User::createFromData(new CreatedUserData($data));
    }

    public function checkUserEmailExists(string $email): bool
    {
        return $this->connection->createQueryBuilder()
            ->select('id')
            ->from($this->table)
            ->where('email = :email')
            ->setParameter('email', $email)
            ->executeQuery()->rowCount() > 0;
    }
}
