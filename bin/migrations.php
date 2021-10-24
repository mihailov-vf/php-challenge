<?php

use DI\ContainerBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

// Set up settings
$containerBuilder->addDefinitions(__DIR__ . '/../config/container.php');
$containerBuilder->useAnnotations(true);
// Build PHP-DI Container instance
$container = $containerBuilder->build();

try {
    $config = new ConfigurationArray($container->get('settings.migrations')->toArray());
    $conn = $container->get(Connection::class);
    $factory = DependencyFactory::fromConnection($config, new ExistingConnection($conn));
    ConsoleRunner::run(dependencyFactory: $factory);
} catch (Throwable $exception) {
    echo $exception->getMessage();
    exit(1);
}
