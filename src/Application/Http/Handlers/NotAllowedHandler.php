<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers;

use Slim\Http\Request;
use Slim\Http\Response;
use Teapot\StatusCode;

class NotAllowedHandler
{
    public function __invoke(Request $request, Response $response): Response
    {
        $response->getBody()->write('Not Allowed');

        return $response->withStatus(StatusCode::METHOD_NOT_ALLOWED);
    }
}
