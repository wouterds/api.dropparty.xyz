<?php

namespace WouterDeSchuyter\DropParty\Application\Http;

use Slim\App;
use WouterDeSchuyter\DropParty\Application\Container;

class Application extends App
{
    public function __construct()
    {
        parent::__construct(Container::load());

        require_once __DIR__ . '/routes.php';
    }
}
