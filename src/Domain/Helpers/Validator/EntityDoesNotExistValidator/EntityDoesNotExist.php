<?php

namespace Domain\Helpers\Validator\EntityDoesNotExistValidator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(
    Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE,
)]
final class EntityDoesNotExist extends Constraint
{
    public function __construct(
        /** @var class-string */
        public string $entityClass,
        public string $entityField,
        public string $message = 'Сущность существует.',
    ) {
        parent::__construct();
    }
}
