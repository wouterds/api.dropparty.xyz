<?php

namespace WouterDeSchuyter\DropParty\Application\Http;

use Slim\App;

class Application extends App
{
    public function __construct()
    {
        parent::__construct([]);

        require_once __DIR__ . '/routes.php';
    }
}
