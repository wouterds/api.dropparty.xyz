<?php

/** @var Slim\App $this */

use WouterDeSchuyter\DropParty\Application\Http\Handlers\AuthHandler;
use WouterDeSchuyter\DropParty\Application\Http\Handlers\AuthVerifyTokenHandler;
use WouterDeSchuyter\DropParty\Application\Http\Handlers\Files\UploadHandler as FilesUploadHandler;
use WouterDeSchuyter\DropParty\Application\Http\Handlers\Files\GetHandler as FilesGetHandler;
use WouterDeSchuyter\DropParty\Application\Http\Middlewares\AuthenticatedUserMiddleware;

$this->get('/auth', AuthHandler::class)->setName('auth');
$this->post('/auth.verify', AuthVerifyTokenHandler::class)->setName('auth');

$this->post('/files.upload', FilesUploadHandler::class)->add(AuthenticatedUserMiddleware::class);
$this->get('/files.get', FilesGetHandler::class);
