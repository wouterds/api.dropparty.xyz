<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers;

use Slim\Http\Request;
use Slim\Http\Response;
use Throwable;
use Tracy\Debugger;

class ExceptionHandler
{
    public function __invoke(Request $request, Response $response, Throwable $e)
    {
        Debugger::exceptionHandler($e, true);
    }
}
