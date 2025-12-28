<?php

namespace Tests\Utils\TestCases;

trait HelperMethodsTrait
{
    /**
     * @template T of object
     *
     * @param class-string<T> $serviceClassName
     *
     * @return T
     */
    final protected function getServiceByClassName(string $serviceClassName): object
    {
        return $this->getServiceByInterface($serviceClassName, $serviceClassName);
    }

    /**
     * @template TInterfaceClassName of object
     * @template TExpectedServiceClassName of object
     *
     * @param class-string<TInterfaceClassName> $interfaceClassName
     * @param class-string<TExpectedServiceClassName> $expectedServiceClassName
     *
     * @return TExpectedServiceClassName
     */
    final protected function getServiceByInterface(string $interfaceClassName, string $expectedServiceClassName): object
    {
        $service = self::getContainer()->get($interfaceClassName);

        \assert($service instanceof $expectedServiceClassName);

        return $service;
    }
}
