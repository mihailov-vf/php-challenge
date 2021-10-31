<?php

declare(strict_types=1);

namespace PhpChallenge\Infra\Http\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ImportAction
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        var_dump(
            $request->getHeaders(),
            $request->getBody()->getContents(),
            count($request->getUploadedFiles()),
            $request->getParsedBody()
        );
        return $response;
    }
}
