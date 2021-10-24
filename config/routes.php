<?php

use PhpChallenge\Infra\Http\Action\DocAction;
use Slim\App;

return function (App $app) {
    $app->get('/', DocAction::class)->setName('home');
};
