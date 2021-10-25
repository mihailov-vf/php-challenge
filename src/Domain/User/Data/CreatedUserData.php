<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\User\Data;

use DateTimeImmutable;
use PhpChallenge\Common\Data\DataFilterTrait;

class CreatedUserData
{
    use DataFilterTrait;

    public string $id;
    public string $email;
    public string $name;
    public string $password;
    public string $token;
    public DateTimeImmutable $created_at;
    public bool $enabled;

    /**
     * @param array{
     *  id:string,
     *  email:string,
     *  name:string,
     *  password:string,
     *  token:string,
     *  created_at:\DateTimeImmutable,
     *  enabled:bool
     * } $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->name = $data['name'];
        $this->password = $data['password'];
        $this->token = $data['token'];
        $this->created_at = $data['created_at'];
        $this->enabled = $data['enabled'];
    }
}
