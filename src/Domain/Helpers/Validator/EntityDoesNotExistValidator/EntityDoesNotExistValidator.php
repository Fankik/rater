<?php

namespace Domain\Helpers\Validator\EntityDoesNotExistValidator;

use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Throwable;
use Webmozart\Assert\Assert;

final class EntityDoesNotExistValidator extends ConstraintValidator
{
    public function __construct(
        private readonly ManagerRegistry $managerRegistry,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        Assert::isInstanceOf($constraint, EntityDoesNotExist::class);

        if (!$value) {
            return;
        }

        try {
            $entityRepository = $this->managerRegistry->getManagerForClass($constraint->entityClass)?->getRepository($constraint->entityClass);
            \assert($entityRepository instanceof EntityRepository);

            $entity = $entityRepository->findOneBy([$constraint->entityField => $value]);
        } catch (Throwable) {
            $this->addViolation($constraint);

            return;
        }

        if (!$entity) {
            return;
        }

        $this->addViolation($constraint);
    }

    private function addViolation(EntityDoesNotExist $constraint): void
    {
        $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
    }
}
