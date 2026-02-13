<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

$dotenv = new Dotenv();

// Load .env file first
$envPath = dirname(__DIR__).'/.env';
if (file_exists($envPath)) {
    $dotenv->load($envPath);
}

// Load .env.local to override with local settings (like remote DB)
// This must be loaded after .env and will override its values
$envLocalPath = dirname(__DIR__).'/.env.local';
if (file_exists($envLocalPath)) {
    // Parse the file and manually set variables to ensure override
    $vars = $dotenv->parse(file_get_contents($envLocalPath), $envLocalPath);
    foreach ($vars as $name => $value) {
        // Don't override APP_ENV if it's already set to 'test' (by PHPUnit)
        if ($name === 'APP_ENV' && isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] === 'test') {
            continue;
        }
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
        putenv("$name=$value");
    }
}

// Load .env.test if it exists (for test-specific overrides)
$envTestPath = dirname(__DIR__).'/.env.test';
if (file_exists($envTestPath)) {
    $vars = $dotenv->parse(file_get_contents($envTestPath), $envTestPath);
    foreach ($vars as $name => $value) {
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
        putenv("$name=$value");
    }
}

// Ensure APP_ENV is set to 'test' for PHPUnit tests
$_ENV['APP_ENV'] = 'test';
$_SERVER['APP_ENV'] = 'test';
putenv('APP_ENV=test');

if (isset($_SERVER['APP_DEBUG']) && $_SERVER['APP_DEBUG']) {
    umask(0000);
}
