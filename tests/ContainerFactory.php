<?php

namespace PhpChallenge\Tests;

use DI\Container;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

/**
 * Container Factory.
 */
final class ContainerFactory
{
    /**
     * Get container.
     *
     * @return ContainerInterface|Container The container
     */
    public static function createInstance(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();

        // Set up settings
        $containerBuilder->addDefinitions(dirname(__DIR__) . '/config/container.php');

        // Build PHP-DI Container instance
        return $containerBuilder->build();
    }
}
