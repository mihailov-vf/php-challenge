<?php

declare(strict_types=1);

namespace PhpChallenge\Tests\Traits;

use PhpChallenge\Tests\ContainerFactory;
use Selective\TestTrait\Traits\ArrayTestTrait;
use Selective\TestTrait\Traits\ContainerTestTrait;
use Selective\TestTrait\Traits\MockTestTrait;

/**
 * App Test Trait.
 */
trait IntegrationTestTrait
{
    use ArrayTestTrait;
    use ContainerTestTrait;
    use MockTestTrait;

    /**
     * Before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $container = ContainerFactory::createInstance();

        $this->setUpContainer($container);
        if (method_exists($this, 'setUpDatabase')) {
            $this->setUpDatabase();
        }
    }
}
