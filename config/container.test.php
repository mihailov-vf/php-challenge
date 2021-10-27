<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Configuration as DoctrineConfiguration;
use Doctrine\DBAL\DriverManager;
use Laminas\Config\Config;
use Psr\Container\ContainerInterface;

$container = require 'container.php';

$container['settings'] = function () {
    return require __DIR__ . '/settings.test.php';
};

$container[Connection::class] = function (ContainerInterface $container) {
    $config = new DoctrineConfiguration();
    $connectionParams = $container->get('settings')['db']->toArray();

    return DriverManager::getConnection($connectionParams, $config);
};

return $container;
