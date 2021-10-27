<?php

use DI\Factory\RequestedEntry;
use Doctrine\DBAL\Configuration as DoctrineConfiguration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Laminas\Config\Config;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\ResourceServer;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\AuthenticationMiddleware;
use Mezzio\Authentication\AuthenticationMiddlewareFactory;
use Mezzio\Authentication\OAuth2\OAuth2Adapter;
use Mezzio\Authentication\OAuth2\Repository\Pdo\AccessTokenRepositoryFactory;
use Mezzio\Authentication\OAuth2\Repository\Pdo\PdoService;
use Mezzio\Authentication\OAuth2\ResourceServerFactory;
use Mezzio\Authentication\UserInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use PhpChallenge\Infra\Auth\AuthUserFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\PhpRenderer;
use Symfony\Component\Console\Application as ConsoleApplication;

use function DI\autowire;
use function DI\factory;
use function DI\get;

return [
    Config::class => function () {
        return new Config(require __DIR__ . '/settings.php');
    },

    'config' => get(Config::class),
    'settings' => get(Config::class),
    'settings.*' => function (RequestedEntry $entry, ContainerInterface $container) {
        return $container->get(Config::class)->get(str_replace('settings.', '', $entry->getName()));
    },

    UserInterface::class => factory(AuthUserFactory::class),
    PdoService::class => get(PDO::class),
    AccessTokenRepositoryInterface::class => factory(AccessTokenRepositoryFactory::class),
    ResourceServer::class => factory(ResourceServerFactory::class),
    AuthenticationInterface::class => function (ContainerInterface $container) {
        return new OAuth2Adapter(
            $container->get(ResourceServer::class),
            function () use ($container) {
                return $container->get(ResponseFactoryInterface::class)->createResponse();
            },
            $container->get(AuthUserFactory::class)
        );
    },
    AuthenticationMiddleware::class => factory(AuthenticationMiddlewareFactory::class),

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

    ServerRequestFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(Psr17Factory::class);
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings.error');

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
        $connection = $container->get(Connection::class)->getWrappedConnection();
        return $connection instanceof Doctrine\DBAL\Driver\PDO\Connection ? $connection->getWrappedConnection() : null;
    },

    'PhpChallenge\Domain\*\*Repository' => autowire('PhpChallenge\Infra\Repository\*\*DbalRepository'),
];
