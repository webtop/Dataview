<?php
    declare(strict_types=1);

    // Common projects constants
    const IS_DEV_MODE = true;
    const CACHE = null;
    const ANNOTATION_READER = false;

    // Database connection parameters, possibly from .env file...
    $DB_HOST = getenv('DB_HOST') ?? 'dataview-mysql:33061';
    $DB_NAME = getenv('DB_NAME') ?? 'classicmodels';
    $DB_USER = getenv('DB_USER') ?? 'dataview';
    $DB_PASS = getenv('DB_PASS') ?? 'QnQbB8000$10';
    $MAPS_API_KEY = getenv('MAPS_API_KEY') ?? "You need an API key -- they're free!";

    // ...so we set them up using defines from above.
    define('DB_HOST', $DB_HOST);
    define('DB_NAME', $DB_NAME);
    define('DB_USER', $DB_USER);
    define('DB_PASS', $DB_PASS);
    define('MAPS_API_KEY', $MAPS_API_KEY);

    // Paths to the project roots.
    define("ROOT", realpath(__DIR__ . '/../'));
    define("LOG_ROOT", realpath(__DIR__ . '/../logs/'));
    define("CONFIG_ROOT", realpath(__DIR__ . '/'));
    define("ENTITY_PATH", realpath(__DIR__ . '/../src/Entity/'));
    define("PROXY_PATH", realpath(__DIR__ . '/../temp/Proxy/'));
    define("CACHE_PATH", realpath(__DIR__ . '/../temp/Cache/'));
