<?php

use PhpChallenge\Infra\Http\Action\CreateUserAction;
use PhpChallenge\Infra\Http\Action\DocAction;
use PhpChallenge\Infra\Http\Action\ImportAction;
// use PhpChallenge\Infra\Http\Action\ImportDetailsAction;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;

return function (App $app) {
    $app->get('/', DocAction::class)->setName('home');
    $app->post('/api/users', CreateUserAction::class)->setName('users_create');

    $app->group('/api/import', function (RouteCollectorProxyInterface $import) {
        $import->post('[/]', ImportAction::class);
        // $import->get('/{id}', ImportDetailsAction::class);
    });
};
