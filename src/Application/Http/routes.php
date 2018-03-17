<?php

/** @var Slim\App $this */

use WouterDeSchuyter\DropParty\Application\Http\Handlers\AuthenticateHandler;
use WouterDeSchuyter\DropParty\Application\Http\Handlers\AuthenticateVerifyTokenHandler;

$this->get('/authenticate', AuthenticateHandler::class)->setName('authenticate');
$this->post('/authenticate/verify-token', AuthenticateVerifyTokenHandler::class)->setName('authenticate.verify-token');
