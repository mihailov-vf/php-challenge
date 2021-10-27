<?php

// Should be set to 0 in production
error_reporting(E_ALL);

// Should be set to '0' in production
ini_set('display_errors', '1');

// Timezone
date_default_timezone_set('UTC');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';
$settings['template'] = $settings['root'] . '/templates';
$settings['resources'] = $settings['root'] . '/resources';
$settings['swagger'] = $settings['resources'] . '/swagger/v1.yaml';

// Authentication settings
$settings['authentication'] = require 'authentication.php';

// Error Handling Middleware settings
$settings['error'] = [

    // Should be set to false in production
    'display_error_details' => true,

    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,
];

// Logger settings
$settings['logger'] = [
    'name' => 'app',
    'path' => $settings['root'] . '/logs',
    'filename' => 'app.log',
    'level' => \Monolog\Logger::INFO,
    'file_permission' => 0775,
];

$settings['commands'] = [
];

// Database settings
$settings['db'] = [
    'driver' => 'pdo_pgsql',
    'host' => 'postgres',
    'dbname' => 'php_challenge',
    'user' => 'postgres',
    'password' => 'postgres',
    'driverOptions' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];

$settings['migrations'] = [
    'table_storage' => [
        'table_name' => 'migrations',
    ],
    'migrations_paths' => [
        'PhpChallenge\Migrations' => $settings['root'] . '/migrations',
    ],

    'all_or_nothing' => true,
    'transactional' => true,
    'check_database_platform' => true,
    'organize_migrations' => 'year',
];

// Template settings
$settings['view'] = [
    // Path to templates
    'path' => $settings['template'],
];

return $settings;
