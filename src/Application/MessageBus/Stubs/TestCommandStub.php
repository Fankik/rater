<?php

namespace Application\MessageBus\Stubs;

use Domain\MessageBus\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TestCommandStub implements CommandInterface
{
    #[Assert\NotBlank]
    public string $string = 'test';
}
