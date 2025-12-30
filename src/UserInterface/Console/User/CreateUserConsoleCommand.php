<?php

namespace UserInterface\Console\User;

use Application\User\UseCases\CreateUserUseCase;
use Domain\MessageBus\CommandBusInterface;
use Domain\User\Entity\ValueObjects\UserRole;
use Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Uid\Uuid;

#[AsCommand(name: 'user:create', description: 'Создать пользователя')]
final class CreateUserConsoleCommand extends Command
{
    private InputInterface $input;
    private OutputInterface $output;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly CommandBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

        $this->createUserFor();

        return self::SUCCESS;
    }

    private function createUserFor(): void
    {
        $useCase = new CreateUserUseCase();

        $useCase->id = Uuid::v7();
        $useCase->name = $this->getValidName();
        $useCase->email = $this->getValidEmail();
        $useCase->password = $this->getValidPassword();
        $useCase->roles = $this->getValidRoles();

        $this->commandBus->dispatch($useCase);

        $this->output->writeln(sprintf('<fg=green>User "%s" успешно создан!</>', $useCase->id));
    }

    private function getValidName(): string
    {
        return $this->ask('<fg=blue>Имя: </>');
    }

    private function getValidEmail(): string
    {
        $email = $this->ask('<fg=blue>Email: </>');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->output->writeln('<fg=red>Введен некорректный email.</>');

            return $this->getValidEmail();
        }

        if ($this->emailIsUnique($email)) {
            return $email;
        }

        $this->output->writeln(sprintf('<fg=red>Email "%s" уже существует.</>', $email));

        return $this->getValidEmail();
    }

    private function getValidPassword(): string
    {
        $password = $this->ask('<fg=blue>Пароль: </>');

        if (mb_strlen($password) < 6) {
            $this->output->writeln('<fg=red>Минимально допустимый пароль 6 символов.</>');

            return $this->getValidPassword();
        }

        return $password;
    }

    /** @return array<string> */
    private function getValidRoles(): array
    {
        return $this->multipleChoice('<fg=blue>Выберите роль: </>', UserRole::values());
    }

    private function emailIsUnique(string $email): bool
    {
        $foundUser = $this->userRepository->findByEmail($email);

        return $foundUser === null;
    }

    private function ask(string $message): string
    {
        $helper = $this->getHelper('question');
        \assert($helper instanceof QuestionHelper);

        $question = new Question($message, null);

        return trim($helper->ask($this->input, $this->output, $question));
    }

    /**
     * @param array<string> $choices
     *
     * @return array<string>
     */
    private function multipleChoice(string $message, array $choices): array
    {
        $helper = $this->getHelper('question');
        \assert($helper instanceof QuestionHelper);

        $question = new ChoiceQuestion(
            $message,
            $choices,
        );
        $question->setMultiselect(true);

        return $helper->ask($this->input, $this->output, $question);
    }
}
