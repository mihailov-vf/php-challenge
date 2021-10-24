<?php

use DI\Factory\RequestedEntry;
use Doctrine\DBAL\Configuration as DoctrineConfiguration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Laminas\Config\Config;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\PhpRenderer;
use Symfony\Component\Console\Application as ConsoleApplication;

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

    ConsoleApplication::class => function (ContainerInterface $container) {
        $application = new ConsoleApplication();

        foreach ($container->get('settings.commands') as $command) {
            if (!is_object($command)) {
                $command = $container->get($command);
            }
            $application->add($command);
        }

        return $application;
    },

    // Database connection
    Connection::class => function (ContainerInterface $container) {
        $config = new DoctrineConfiguration();
        $connectionParams = $container->get('settings')['db']->toArray();

        return DriverManager::getConnection($connectionParams, $config);
    },

    PDO::class => function (ContainerInterface $container) {
        return $container->get(Connection::class)->getWrappedConnection();
    },
];
