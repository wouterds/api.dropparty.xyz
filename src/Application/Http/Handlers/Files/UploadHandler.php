<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers\Files;

use Slim\Http\Request;
use Slim\Http\Response;

class UploadHandler
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $response->getBody()->write('Hello World');

        return $response;
    }
}
