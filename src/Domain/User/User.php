<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\User;

use DateTimeImmutable;
use PhpChallenge\Common\Object\Entity;
use PhpChallenge\Common\Object\Uuid;
use PhpChallenge\Domain\User\Data\CreatedUserData;
use PhpChallenge\Domain\User\Data\CreateNewUserData;

class User extends Entity
{
    private string $email;
    private string $name;
    private string $password;
    private AccessToken $token;
    private DateTimeImmutable $createdAt;
    private bool $enabled = true;

    public static function createNewFromData(CreateNewUserData $data): self
    {
        $user = new User(Uuid::createUuidString(), $data->email, $data->name, $data->password);
        $user->token = AccessToken::createToken();
        $user->createdAt = new DateTimeImmutable();
        return $user;
    }

    public static function createFromData(CreatedUserData $data): self
    {
        $user = new User($data->id, $data->email, $data->name, $data->password);
        $user->token = new AccessToken($data->token);
        $user->createdAt = DateTimeImmutable::createFromInterface($data->created_at);
        $user->enabled = $data->enabled;
        return $user;
    }

    public function __construct(string $id, string $email, string $name, string $password)
    {
        parent::__construct($id);
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getToken(): AccessToken
    {
        return $this->token;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function toData(): CreatedUserData
    {
        $data = new CreatedUserData([
            'id' => (string)$this->getId(),
            'email' => $this->email,
            'name' => $this->name,
            'password' => $this->password,
            'token' => (string)$this->token,
            'created_at' => $this->createdAt,
            'enabled' => $this->enabled,
        ]);
        return $data;
    }
}
