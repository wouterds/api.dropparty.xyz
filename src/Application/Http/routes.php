<?php

/** @var Slim\App $this */

use WouterDeSchuyter\DropParty\Application\Http\Handlers\AuthHandler;
use WouterDeSchuyter\DropParty\Application\Http\Handlers\AuthVerifyTokenHandler;

$this->get('/auth', AuthHandler::class)->setName('auth');
$this->post('/auth.verify', AuthVerifyTokenHandler::class)->setName('auth');
