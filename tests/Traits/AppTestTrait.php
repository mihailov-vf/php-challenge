<?php

declare(strict_types=1);

namespace PhpChallenge\Tests\Traits;

use PhpChallenge\Tests\ContainerFactory;
use Psr\Container\ContainerInterface;
use Selective\TestTrait\Traits\ArrayTestTrait;
use Selective\TestTrait\Traits\ContainerTestTrait;
use Selective\TestTrait\Traits\HttpJsonTestTrait;
use Selective\TestTrait\Traits\HttpTestTrait;
use Selective\TestTrait\Traits\MockTestTrait;
use Slim\App;

/**
 * App Test Trait.
 */
trait AppTestTrait
{
    use ArrayTestTrait;
    use ContainerTestTrait;
    use HttpTestTrait;
    use HttpJsonTestTrait;
    use MockTestTrait;
    use RouteTestTrait;

    protected App $app;

    /**
     * Before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $container = ContainerFactory::createInstance();
        $this->app = $container->get(App::class);

        $this->setUpContainer($container);
    }
}
