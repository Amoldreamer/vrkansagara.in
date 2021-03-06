<?php

use Laminas\Mvc\Application;

define('REQUEST_MICROTIME', microtime(true));

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';



if (! class_exists(Application::class)) {
    throw new RuntimeException(
        "Unable to load application.\n"
        . "- Type `composer install` if you are developing locally.\n"
        . "- Type `vagrant ssh -c 'composer install'` if you are using Vagrant.\n"
        . "- Type `docker-compose run laminas composer install` if you are using Docker.\n"
    );
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */

chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (is_string($path) && __FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}


$configFile = __DIR__ . '/../.env';
if (file_exists($configFile) || $configFile = __DIR__ . '/../.env.dist') {
    $dotenv = new Symfony\Component\Dotenv\Dotenv();
    $dotenv->load($configFile);
}


if (is_production_mode()) {
    Sentry\init([
        'dsn' => env('SENTRY_API_KEY'),
        'traces_sample_rate' => 1.0 # be sure to lower this in production to prevent quota issues
    ]);
}
date_default_timezone_set(env('APP_TIMEZONE'));
