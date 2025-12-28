<?php

namespace Application\MessageBus\Stubs;

use Domain\MessageBus\QueryInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TestQueryStub implements QueryInterface
{
    #[Assert\NotBlank]
    public string $string = 'test';
}
