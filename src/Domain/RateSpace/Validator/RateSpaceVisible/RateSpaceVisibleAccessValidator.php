<?php

namespace Domain\RateSpace\Validator\RateSpaceVisible;

use Domain\RateSpace\Entity\ValueObjects\RateSpaceVisibleType;
use Domain\RateSpace\Repository\RateSpaceRepositoryInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Throwable;

final class RateSpaceVisibleAccessValidator extends ConstraintValidator
{
    public function __construct(
        private readonly RateSpaceRepositoryInterface $rateSpaceRepository,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        \assert($constraint instanceof RateSpaceVisibleAccess);

        if (!$value) {
            return;
        }

        try {
            $rateSpace = $this->rateSpaceRepository->findById(Uuid::fromString($value));
        } catch (Throwable) {
            $this->addViolation();

            return;
        }

        if (!$rateSpace) {
            return;
        }

        if ($rateSpace->getVisibleType() === RateSpaceVisibleType::Public) {
            return;
        }

        $this->addViolation();
    }

    private function addViolation(): void
    {
        $this->context
            ->buildViolation(RateSpaceVisibleAccess::NOT_ACCESS_MESSAGE)
            ->addViolation();
    }
}
