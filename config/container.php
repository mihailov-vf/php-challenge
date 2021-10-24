<?php

use DI\Factory\RequestedEntry;
use Laminas\Config\Config;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\PhpRenderer;

return [
    Config::class => function () {
        return new Config(require __DIR__ . '/settings.php');
    },

    'settings' => function (RequestedEntry $entry, ContainerInterface $container) {
        return $container->get(Config::class);
    },
    'settings.*' => function (RequestedEntry $entry, ContainerInterface $container) {
        return $container->get(Config::class)->get(str_replace('settings.', '', $entry->getName()));
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        $app =  AppFactory::create();

        // Register routes
        (require __DIR__ . '/routes.php')($app);

        // Register middleware
        (require __DIR__ . '/middleware.php')($app);

        return $app;
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    PhpRenderer::class => function (ContainerInterface $container) {
        return new PhpRenderer($container->get('settings')['view']['path']);
    },
];
