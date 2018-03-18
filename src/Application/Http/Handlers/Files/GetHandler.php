<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers\Files;

use Slim\Http\Request;
use Slim\Http\Response;
use Teapot\StatusCode;
use WouterDeSchuyter\DropParty\Domain\Files\FileId;
use WouterDeSchuyter\DropParty\Domain\Files\FileRepository;

class GetHandler
{
    /**
     * @var FileRepository
     */
    private $fileRepository;

    /**
     * @param FileRepository $fileRepository
     */
    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        if (empty($request->getParsedBodyParam('fileId'))) {
            return $response->withStatus(StatusCode::NOT_FOUND);
        }

        $fileId = new FileId($request->getParsedBodyParam('fileId'));

        $file = $this->fileRepository->getById($fileId);

        dump($file);exit;
    }
}
