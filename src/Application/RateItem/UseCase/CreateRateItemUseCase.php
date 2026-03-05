<?php

namespace Application\RateItem\UseCase;

use Domain\Helpers\Validator\EntityExistsValidator\EntityExists;
use Domain\MessageBus\CommandInterface;
use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Validator\RateSpaceVisible\RateSpaceVisibleAccess;
use Domain\User\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateRateItemUseCase implements CommandInterface
{
    #[Assert\NotBlank(message: 'Название должно быть заполнено.')]
    public string $title;

    public string $description = '';

    #[Assert\NotBlank(message: 'Оценка должна быть заполнена.')]
    #[Assert\Positive(message: 'Оценка не может быть отрицательной.')]
    #[Assert\Type(type: 'float', message: 'Оценка должна быть числом.')]
    public mixed $score;

    #[EntityExists(
        entityClass: RateSpace::class,
        entityField: 'id',
        message: 'Пространства не существует.',
    )]
    #[RateSpaceVisibleAccess]
    public string $rateSpaceId;

    #[EntityExists(
        entityClass: User::class,
        entityField: 'id',
        message: 'Пользователь не найден.',
    )]
    public string $userId;
}
