<?php

use WouterDeSchuyter\DropParty\Application\Http\Application;

// Define application directory once at entrypoint
define('APP_DIR', dirname(__DIR__));

// Load autoloader
require_once APP_DIR . '/vendor/autoload.php';

// Run application
(new Application())->run();
