<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\User\Data;

class CreateNewUserData
{
    public ?string $id;
    public string $email;
    public string $name;
    public string $password;
    
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->email = $data['email'];
        $this->name = $data['name'];
        $this->password = $data['password'];
    }
}
