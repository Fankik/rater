<?php

use Doctrine\Persistence\ManagerRegistry;
use Infrastructure\CodeStyle\PHPStan\Doctrine\ObjectManagerForPhpStan;
use Infrastructure\Kernel;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../../../../vendor/autoload.php';

(new Dotenv())->bootEnv(__DIR__ . '/../../../../.env');

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();

$managerRegistry = $kernel->getContainer()->get('doctrine');
assert($managerRegistry instanceof ManagerRegistry);

return new ObjectManagerForPhpStan($managerRegistry);
