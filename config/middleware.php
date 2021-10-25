<?php

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    $app->add(BasePathMiddleware::class);

    // Catch exceptions and errors
    $error = $app->addErrorMiddleware(true, false, false);
    $error->setErrorHandler(DomainException::class, function (ServerRequestInterface $request, Throwable $exception) use ($app) {
        $payload = ['error' => $exception->getMessage()];

        $response = $app->getResponseFactory()->createResponse();
        $response->getBody()->write(
            json_encode($payload, JSON_UNESCAPED_UNICODE)
        );

        return $response->withHeader('Content-type', 'application/json')->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
    }, true);
};
