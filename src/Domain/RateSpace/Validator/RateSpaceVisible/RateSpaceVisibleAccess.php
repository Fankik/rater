<?php

namespace Domain\RateSpace\Validator\RateSpaceVisible;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(
    Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE,
)]
final class RateSpaceVisibleAccess extends Constraint
{
    public const string NOT_ACCESS_MESSAGE = 'Нельзя добавить элемент к пространству.';
}
