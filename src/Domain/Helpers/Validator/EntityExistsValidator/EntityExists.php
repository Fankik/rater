<?php

namespace Domain\Helpers\Validator\EntityExistsValidator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(
    Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE,
)]
final class EntityExists extends Constraint
{
    public function __construct(
        /** @var class-string */
        public string $entityClass,
        public string $entityField,
        public string $message = 'Сущность не существует.',
    ) {
        parent::__construct();
    }
}
