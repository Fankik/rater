<?php

namespace Tests\Utils\TestCases;

use Domain\MessageBus\CommandBusInterface;
use Domain\MessageBus\QueryBusInterface;
use Infrastructure\MessageBus\TestCommandBus;
use Infrastructure\MessageBus\TestQueryBus;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class FunctionalTestCase extends KernelTestCase
{
    use HelperMethodsTrait;

    protected function setUp(): void
    {
        parent::setUp();

        static::bootKernel();
    }

    protected function tearDown(): void
    {
        self::ensureKernelShutdown();

        parent::tearDown();
    }

    final protected function getCommandBus(): TestCommandBus
    {
        return $this->getServiceByInterface(CommandBusInterface::class, TestCommandBus::class);
    }

    final protected function getQueryBus(): TestQueryBus
    {
        return $this->getServiceByInterface(QueryBusInterface::class, TestQueryBus::class);
    }
}
