<?php

declare(strict_types=1);

namespace PhpChallenge\Infra\Http\Action;

use Fig\Http\Message\StatusCodeInterface;
use PhpChallenge\Domain\User\Data\CreateNewUserData;
use PhpChallenge\Domain\User\Service\CreateUser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateUserAction
{
    public function __construct(private CreateUser $createUserService)
    {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $createUserData = new CreateNewUserData((array)$request->getParsedBody());
        $createdUser = $this->createUserService->execute($createUserData)->filter(
            'id',
            'email',
            'name',
            'created_at',
        );

        $response->getBody()->write(json_encode($createdUser) ?: '');
        return $response->withHeader('Content-type', 'application/json')
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
