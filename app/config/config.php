<?php
    declare(strict_types=1);

    // Common projects constants
    const IS_DEV_MODE = true;
    const CACHE = null;
    const ANNOTATION_READER = false;
    const ENTITY_PATH = __DIR__ . '/../src/Entity';
    const PROXY_PATH = __DIR__ . '/../temp/Proxy';
    const CACHE_PATH = __DIR__ . '/../temp/Cache';
    const DB_PREF = '';

    // Database connection parameters, possibly from .env file...
    $DB_HOST = getenv('DB_HOST') ?? 'localhost:8080';
    $DB_NAME = getenv('DB_NAME') ?? 'classicmodels';
    $DB_USER = getenv('DB_USER') ?? 'dataview';
    $DB_PASS = getenv('DB_PASS') ?? 'QnQbB8000$10';

    // ...so we set them up using defines from above.
    define('DB_HOST', $DB_HOST);
    define('DB_NAME', $DB_NAME);
    define('DB_USER', $DB_USER);
    define('DB_PASS', $DB_PASS);

    // Paths to the project roots.
    define("ROOT", realpath(__DIR__ . '/../'));
    define("LOG_ROOT", realpath(__DIR__ . '/../logs/'));
    define("CONFIG_ROOT", realpath(__DIR__ . '/'));
