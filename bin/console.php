<?php

use DI\ContainerBuilder;
use Doctrine\DBAL\Tools\Console\ConnectionProvider\SingleConnectionProvider;
use Doctrine\DBAL\Tools\Console\ConsoleRunner;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerName = !empty($_ENV['TEST']) ? '.test' : '';

// Set up settings
$containerBuilder->addDefinitions(dirname(__DIR__) . "/config/container{$containerName}.php");
$containerBuilder->useAnnotations(true);
// Build PHP-DI Container instance
$container = $containerBuilder->build();

try {
    ConsoleRunner::run($container->get(SingleConnectionProvider::class));
} catch (Throwable $exception) {
    echo $exception->getMessage();
    exit(1);
}
