<?php

use PhpChallenge\Infra\Http\Action\CreateUserAction;
use PhpChallenge\Infra\Http\Action\DocAction;
use Slim\App;

return function (App $app) {
    $app->get('/', DocAction::class)->setName('home');
    $app->post('/api/users', CreateUserAction::class)->setName('users_create');
};
