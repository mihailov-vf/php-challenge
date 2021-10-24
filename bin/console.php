<?php

use DI\ContainerBuilder;
use Doctrine\DBAL\Tools\Console\ConnectionProvider\SingleConnectionProvider;
use Doctrine\DBAL\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$env = (new ArgvInput())->getParameterOption(['--env', '-e'], 'dev');
if ($env) {
    $_ENV['APP_ENV'] = $env;
}

// Set up settings
$containerBuilder->addDefinitions(__DIR__ . '/../config/container.php');
$containerBuilder->useAnnotations(true);
// Build PHP-DI Container instance
$container = $containerBuilder->build();

try {
    ConsoleRunner::run($container->get(SingleConnectionProvider::class));
} catch (Throwable $exception) {
    echo $exception->getMessage();
    exit(1);
}