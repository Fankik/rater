<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

$needClearCacheBeforeTesting = filter_var($_ENV['CLEAR_CACHE_BEFORE_TESTING'] ?? true, FILTER_VALIDATE_BOOLEAN);
$needRecreateDatabasesBeforeTesting = filter_var($_ENV['RECREATE_DATABASE_BEFORE_TESTING'] ?? true, FILTER_VALIDATE_BOOLEAN);

if ($needClearCacheBeforeTesting) {
    clearCache();
}

if ($needRecreateDatabasesBeforeTesting) {
    recreateDatabases();
}

function clearCache(): void
{
    passthru(sprintf(
        'php "%s/../bin/console" cache:clear --env=%s --no-warmup',
        __DIR__,
        $_ENV['APP_ENV'],
    ));
}

function recreateDatabases(): void
{
    passthru(sprintf(
        'php "%s/../bin/console" doctrine:database:drop --if-exists --force --env=%s',
        __DIR__,
        $_ENV['APP_ENV'],
    ));

    passthru(sprintf(
        'php "%s/../bin/console" doctrine:database:create --env=%s',
        __DIR__,
        $_ENV['APP_ENV'],
    ));

    passthru(sprintf(
        'php "%s/../bin/console" doctrine:migrations:migrate --no-interaction --env=%s',
        __DIR__,
        $_ENV['APP_ENV'],
    ));
}
