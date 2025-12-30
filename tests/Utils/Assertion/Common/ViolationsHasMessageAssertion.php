<?php

namespace Tests\Utils\Assertion\Common;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ViolationsHasMessageAssertion extends Constraint
{
    private ?ExpectationFailedException $expectationFailedException = null;

    public function __construct(
        private readonly string $expectedPropertyPath,
        private readonly string $expectedMessage,
        private readonly string $assertionMessage = '',
    ) {
    }

    public function toString(): string
    {
        return $this->assertionMessage;
    }

    /** {@inheritDoc} */
    protected function matches(mixed $other): bool
    {
        \assert($other instanceof ConstraintViolationListInterface);

        try {
            self::assertConstraintViolationsHasMessage($this->expectedPropertyPath, $this->expectedMessage, $other);
        } catch (ExpectationFailedException $exception) {
            $this->expectationFailedException = $exception;

            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    protected function failureDescription(mixed $other): string
    {
        \assert($this->expectationFailedException instanceof ExpectationFailedException);

        return sprintf('%s %s', $this->toString(), $this->expectationFailedException->getMessage());
    }

    /**
     * @throws ExpectationFailedException
     */
    private static function assertConstraintViolationsHasMessage(
        string $expectedPropertyPath,
        string $expectedMessage,
        ConstraintViolationListInterface $constraintViolationList,
    ): void {
        $actualMessages = [];

        foreach ($constraintViolationList as $constraintViolation) {
            \assert($constraintViolation instanceof ConstraintViolation);

            if ($constraintViolation->getPropertyPath() !== $expectedPropertyPath) {
                continue;
            }

            $actualMessages[] = $constraintViolation->getMessage();
        }

        Assert::assertContainsEquals($expectedMessage, $actualMessages, 'The message was not found in the constraint violations.');
    }
}
