<?php

namespace Infrastructure\Helpers\Repository;

abstract class AbstractRepositoryStub
{
    protected mixed $expected;

    protected function setExpected(mixed $expected): void
    {
        $this->expected = $expected;
    }

    protected function getExpected(): mixed
    {
        return $this->expected;
    }
}
