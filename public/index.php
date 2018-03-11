<?php

use Tracy\Debugger;
use WouterDeSchuyter\DropParty\Application\Http\Application;

// Define application directory once at entrypoint
define('APP_DIR', dirname(__DIR__));

// Load autoloader
require_once APP_DIR . '/vendor/autoload.php';

// Debugger
$debuggerMode = getenv('APP_ENV') === 'production' ? Debugger::PRODUCTION : Debugger::DEVELOPMENT;
Debugger::$showBar = $debuggerMode === Debugger::DEVELOPMENT;
Debugger::$strictMode = $debuggerMode === Debugger::DEVELOPMENT;
Debugger::enable($debuggerMode, APP_DIR . '/storage/logs');

// Run application
(new Application())->run();
