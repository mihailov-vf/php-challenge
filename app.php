<?php

use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__ . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

// Set up settings
$containerBuilder->addDefinitions(__DIR__ . '/config/container.php');
$containerBuilder->useAnnotations(true);
// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Create App instance
$app = $container->get(App::class);

return $app;
