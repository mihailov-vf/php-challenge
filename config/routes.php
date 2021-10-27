<?php

use Mezzio\Authentication\AuthenticationMiddleware;
use Mezzio\Authentication\OAuth2\AuthorizationHandler;
use Mezzio\Authentication\OAuth2\AuthorizationMiddleware;
use Mezzio\Authentication\OAuth2\TokenEndpointHandler;
use PhpChallenge\Infra\Http\Action\CreateUserAction;
use PhpChallenge\Infra\Http\Action\DocAction;
use PhpChallenge\Infra\Http\Middleware\OAuthAuthorizationMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $response->getBody()->write("Hello! See API docs on <a href=\"{$request->getUri()}api\">{$request->getUri()}api</a>");
        return $response;
    })->setName('home');

    $app->post('/oauth2/token', TokenEndpointHandler::class)->setName('token');
    $app->map(['GET', 'POST'], '/oauth2/authorize', AuthorizationHandler::class)
        ->add(AuthorizationMiddleware::class)
        ->add(OAuthAuthorizationMiddleware::class);

    $app->group('/api', function (RouteCollectorProxy $api) {
        $api->get('[/]', DocAction::class)->setName('api_docs');
        $api->post('/users[/]', CreateUserAction::class)->setName('users_create');
        $api->get('/login[/]', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
            $response->getBody()->write('login');
            return $response;
        })->setName('api_login');

        $api->map([''], '/import[/]', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
            $response->getBody()->write('import');
            return $response;
        })->add(AuthenticationMiddleware::class);
    });
};
