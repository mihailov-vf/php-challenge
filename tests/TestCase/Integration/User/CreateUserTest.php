<?php

declare(strict_types=1);

namespace PhpChallenge\Tests\TestCase\Integration\User;

use PhpChallenge\Domain\User\Data\CreatedUserData;
use PhpChallenge\Domain\User\Data\CreateNewUserData;
use PhpChallenge\Domain\User\Service\CreateUser;
use PhpChallenge\Domain\User\User;
use PhpChallenge\Domain\User\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    private CreateUser $createUserService;
    /** @var UserRepository&MockObject */
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        /** @var UserRepository&MockObject */
        $userRepository = $this->getMockForAbstractClass(
            UserRepository::class,
            mockedMethods: get_class_methods(UserRepository::class)
        );
        $this->createUserService = new CreateUser($userRepository);
        $this->userRepository = $userRepository;
    }


    /**
     * @test
     */
    public function itShouldCreateUserOnValidInput(): void
    {
        $userData = new CreateNewUserData([
            'name' => 'Jane Doe',
            'email' => 'mail@example.com',
            'password' => '12345678',
        ]);
        $this->userRepository
            ->expects($this->once())
            ->method('createUser');

        $createdUser = $this->createUserService->execute($userData);

        $this->assertInstanceOf(CreatedUserData::class, $createdUser);
        $this->assertObjectHasAttribute('id', $createdUser);
        $this->assertEquals('Jane Doe', $createdUser->name);
        $this->assertEquals('mail@example.com', $createdUser->email);
        $this->assertTrue(password_verify('12345678', $createdUser->password));
    }
}
