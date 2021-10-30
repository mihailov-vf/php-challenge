<?php

$settings = require 'settings.php';

$settings['fixtures'] = $settings['root'] . '/fixtures';

// Database settings
$settings['db'] = [
    'driver' => 'pdo_pgsql',
    'host' => 'postgres',
    'dbname' => 'php_challenge_test',
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


return $settings;
