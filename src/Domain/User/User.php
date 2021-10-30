<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\User;

use DateTimeImmutable;
use PhpChallenge\Common\Object\Entity;
use PhpChallenge\Common\Object\Uuid;
use PhpChallenge\Common\Traits\CreatedAtTimestampableTrait;
use PhpChallenge\Domain\User\Data\CreatedUserData;
use PhpChallenge\Domain\User\Data\CreateNewUserData;

class User extends Entity
{
    use CreatedAtTimestampableTrait;

    private string $email;
    private string $name;
    private string $password;
    private ?AccessToken $token;
    private bool $enabled = true;

    public static function createNewFromData(CreateNewUserData $data): self
    {
        $user = new User(Uuid::create(), $data->email, $data->name, $data->password);
        $user->createdAt = new DateTimeImmutable();
        return $user;
    }

    /** @param array<string, mixed> $data */
    public static function createFromArray(array $data): self
    {
        $user = new User($data['id'], $data['email'], $data['name'], $data['password']);
        $user->token = $data['token'] ? new AccessToken($data['token']) : null;
        $user->createdAt = DateTimeImmutable::createFromInterface($data['created_at']);
        $user->enabled = $data['enabled'];
        return $user;
    }

    public function __construct(string|Uuid $id, string $email, string $name, string $password)
    {
        parent::__construct($id);
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getToken(): ?AccessToken
    {
        return $this->token;
    }

    /**
     * @codeCoverageIgnore
     */
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
            'token' => (string)($this->token ?? null),
            'created_at' => $this->createdAt,
            'enabled' => $this->enabled,
        ]);
        return $data;
    }
}
