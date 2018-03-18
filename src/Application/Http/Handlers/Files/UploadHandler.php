<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers\Files;

use Exception;
use Slim\Http\Request;
use Slim\Http\Response;
use Teapot\StatusCode;
use WouterDeSchuyter\DropParty\Domain\Users\AuthenticatedUser;

class UploadHandler
{
    /**
     * @var AuthenticatedUser
     */
    private $authenticatedUser;

    /**
     * @param AuthenticatedUser $authenticatedUser
     */
    public function __construct(AuthenticatedUser $authenticatedUser)
    {
        $this->authenticatedUser = $authenticatedUser;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        try {
            $this->validate($request);
        } catch (Exception $e) {
            return $response->withStatus(StatusCode::BAD_REQUEST);
        }


    }

    /**
     * @param Request $request
     * @throws Exception
     */
    private function validate(Request $request)
    {
        if (empty($request->getUploadedFiles()['file'])) {
            throw new Exception('No files provided!');
        }
    }
}
