<?php

declare(strict_types=1);

namespace PhpChallenge\Tests\TestCase\Functional;

use PhpChallenge\Tests\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PhpChallenge\Tests\Traits\DbalDatabaseTestTrait;
use PHPUnit\Framework\TestCase;

/** @coversNothing */
class CreateUserActionTest extends TestCase
{
    use AppTestTrait;
    use DbalDatabaseTestTrait;

    /**
     * @test
     */
    public function itShouldCreateUser(): void
    {
        $this->truncate('users');
        $request = $this->createJsonRequest(
            'POST',
            '/api/users',
            [
                'name' => 'Jane Doe',
                'email' => 'mail@example.com',
                'password' => '12345678',
            ]
        );

        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
        $this->assertJsonContentType($response);

        $responsePayload = $this->getJsonData($response);
        $this->assertArrayHasKey('id', $responsePayload);
        $this->assertNotEmpty($responsePayload['id']);

        $this->assertTableRowCount(1, 'users');
        $this->assertTableRowExists('users', $responsePayload['id']);
    }

    /** @test */
    public function itShouldNotCreateUserOnDuplicatedEmail(): void
    {
        $this->truncate('users');
        $request = $this->createJsonRequest(
            'POST',
            '/api/users',
            [
                'name' => 'Jane Doe',
                'email' => 'mail@example.com',
                'password' => '12345678',
            ]
        );

        $response = $this->app->handle($request);
        $response = $this->app->handle($request);
        $this->assertSame(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
        $this->assertJsonContentType($response);

        $responsePayload = $this->getJsonData($response);
        $this->assertJsonValue('User already exists', 'error', $response);
    }
}
