<?php

namespace WouterDeSchuyter\DropParty\Migrations;

use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Doctrine\UuidType;

// Define application directory once at entrypoint
define('APP_DIR', __DIR__);

// Load autoloader
require_once APP_DIR . '/vendor/autoload.php';

// Uuid support
Type::addType('uuid', UuidType::class);

return [
    'dbname' => getenv('MYSQL_DATABASE'),
    'user' => getenv('MYSQL_USER'),
    'password' => getenv('MYSQL_PASSWORD'),
    'host' => getenv('MYSQL_HOST'),
    'port' => getenv('MYSQL_PORT'),
    'driver' => 'pdo_mysql',
    'defaultDatabaseOptions' => [
        'charset' => 'utf8mb4',
        'collate' => 'utf8mb4_unicode_ci'
    ],
    'defaultTableOptions' => [
        'charset' => 'utf8mb4',
        'collate' => 'utf8mb4_unicode_ci'
    ],
];
