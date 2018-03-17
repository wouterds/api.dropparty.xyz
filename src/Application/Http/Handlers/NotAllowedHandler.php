<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers;

use Slim\Http\Request;
use Slim\Http\Response;
use Teapot\StatusCode;

class NotAllowedHandler
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        return $response->withStatus(StatusCode::METHOD_NOT_ALLOWED);
    }
}
