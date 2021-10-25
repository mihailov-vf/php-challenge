<?php

declare(strict_types=1);

namespace PhpChallenge\Tests\TestCase\Functional;

use PhpChallenge\Tests\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
// use Selective\TestTrait\Traits\DatabaseTestTrait;

class CreateUserActionTest extends TestCase
{
    use AppTestTrait;
    // use DatabaseTestTrait;

    /** 
     * @test
     */
    public function itShouldCreateUser(): void
    {
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

        // TODO: Correct Database access
        // $this->assertTableRowCount(1, 'users');

        // $expected = [
        //     'username' => 'admin',
        //     'email' => 'mail@example.com',
        //     'first_name' => 'Sally',
        //     'last_name' => 'Doe',
        //     'locale' => 'de_DE',
        //     'timezone' => 'America/Sao_Paulo',
        //     'enabled' => '1',
        // ];

        // $this->assertTableRow($expected, 'users', $responsePayload['id']);

        // TODO: Compare password Hash
        // $password = $this->getTableRowById('users', $responsePayload['id'])['password'];
    }
}
