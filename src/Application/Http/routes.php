<?php

/** @var Slim\App $this */

use WouterDeSchuyter\DropParty\Application\Http\Handlers\AuthenticateHandler;

$this->get('/authenticate', AuthenticateHandler::class)->setName('authenticate');
