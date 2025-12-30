<?php

namespace Application\User\UseCases;

use Domain\Helpers\Validator\EntityDoesNotExistValidator\EntityDoesNotExist;
use Domain\MessageBus\CommandInterface;
use Domain\User\Entity\User;
use Domain\User\Entity\ValueObjects\UserRole;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateUserUseCase implements CommandInterface
{
    public ?Uuid $id = null;

    public string $name;

    #[EntityDoesNotExist(
        entityClass: User::class,
        entityField: 'email',
        message: 'Пользователь с email существует.',
    )]
    #[Assert\Email(message: 'Некорректный Email.')]
    public string $email;

    #[Assert\Length(
        min: 6,
        max: 255,
        minMessage: 'Минимально допустимый пароль {{ limit }} символов.',
        maxMessage: 'Максимально допустимый пароль {{ limit }} символов.',
    )]
    public string $password;

    /** @var array<string> */
    #[Assert\All(
        [
            new Assert\Choice(callback: [UserRole::class, 'values'], message: 'Такой роли не существует.'),
        ],
    )]
    public array $roles;
}
