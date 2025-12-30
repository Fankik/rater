<?php

namespace Tests\UserInterface\Console\User;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CreateUserConsoleCommandTest extends FunctionalTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
    }

    protected function tearDown(): void
    {
        $em = self::getContainer()->get('doctrine.orm.entity_manager');

        $connection = $em->getConnection();
        $connection->executeStatement('DELETE FROM users');

        $em->clear();

        parent::tearDown();
    }

    public function testCommandSuccessfullyCreatesUser(): void
    {
        $commandTester = $this->getCommand();

        $commandTester->setInputs([
            'John Doe',
            'john@example.com',
            'password123',
            '0',
        ]);

        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
        self::assertStringContainsString(
            'User "',
            $commandTester->getDisplay(),
        );

        self::assertStringContainsString(
            'успешно создан!',
            $commandTester->getDisplay(),
        );

        self::assertMatchesRegularExpression(
            '/User "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}" успешно создан!/',
            $commandTester->getDisplay(),
        );
    }

    public function testInvalidEmailShowsError(): void
    {
        $commandTester = $this->getCommand();

        $commandTester->setInputs([
            'John Doe',
            'invalid-email',
            'john@example.com',
            'password123',
            '0',
        ]);

        $commandTester->execute([]);
        $output = $commandTester->getDisplay();

        self::assertStringContainsString('Введен некорректный email.', $output);
    }

    public function testDuplicateEmailShowsError(): void
    {
        $commandTester = $this->getCommand();

        UserFactory::createOne([
            'email' => 'existing@example.com',
        ]);

        $commandTester->setInputs([
            'John Doe',
            'existing@example.com',
            'new@example.com',
            'password123',
            '0',
        ]);

        $commandTester->execute([]);
        $output = $commandTester->getDisplay();

        self::assertStringContainsString('уже существует', $output);
    }

    public function testShortPasswordShowsError(): void
    {
        $commandTester = $this->getCommand();

        $commandTester->setInputs([
            'John Doe',
            'john@example.com',
            '123',
            'password123',
            '0',
        ]);

        $commandTester->execute([]);
        $output = $commandTester->getDisplay();

        self::assertStringContainsString('Минимально допустимый пароль 6 символов.', $output);
    }

    private function getCommand(): CommandTester
    {
        $kernel = self::$kernel;

        assert($kernel instanceof KernelInterface);

        $application = new Application($kernel);

        $command = $application->find('user:create');

        return new CommandTester($command);
    }
}
