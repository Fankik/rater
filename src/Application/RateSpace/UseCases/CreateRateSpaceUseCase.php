<?php

namespace Application\RateSpace\UseCases;

use Domain\Helpers\Validator\EntityDoesNotExistValidator\EntityDoesNotExist;
use Domain\Helpers\Validator\EntityExistsValidator\EntityExists;
use Domain\MessageBus\CommandInterface;
use Domain\RateSpace\Entity\RateSpace;
use Domain\User\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateRateSpaceUseCase implements CommandInterface
{
    #[Assert\NotBlank(message: 'Название должно быть заполнено.')]
    public string $title;

    public string $description = '';

    #[EntityDoesNotExist(
        entityClass: RateSpace::class,
        entityField: 'slug',
        message: 'Такое пространство для оценки уже существует.',
    )]
    public ?string $slug = null;

    #[EntityExists(
        entityClass: User::class,
        entityField: 'id',
        message: 'Пользователь не найден.',
    )]
    public string $userId;
}
