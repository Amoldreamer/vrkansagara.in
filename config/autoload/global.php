<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db' => [
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=vrkansagara.in;host=localhost',
        'driver_options' => [
            1002 => 'SET NAMES \'UTF8\'',
        ],
        'username' => 'YOUR SECRET USER NAME',
        'password' => 'YOUR SECRET PASSWORD',
    ],
    'session' => [
        'config' => [
            'class' => \Laminas\Session\Config\SessionConfig::class,
            'options' => [
                'name' => 'session_name',
            ],
        ],
        'storage' => \Laminas\Session\Storage\SessionArrayStorage::class,
        'validators' => [
            \Laminas\Session\Validator\RemoteAddr::class,
            \Laminas\Session\Validator\HttpUserAgent::class,
        ],
    ],

    ];
