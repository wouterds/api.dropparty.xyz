<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers\Files;

use Exception;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Teapot\StatusCode;
use WouterDeSchuyter\DropParty\Domain\Files\File;
use WouterDeSchuyter\DropParty\Domain\Files\FileRepository;
use WouterDeSchuyter\DropParty\Domain\Users\AuthenticatedUser;
use WouterDeSchuyter\DropParty\Infrastructure\Filesystem\Filesystem;

class UploadHandler
{
    /**
     * @var AuthenticatedUser
     */
    private $authenticatedUser;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var FileRepository
     */
    private $fileRepository;

    /**
     * @param AuthenticatedUser $authenticatedUser
     * @param Filesystem $filesystem
     * @param FileRepository $fileRepository
     */
    public function __construct(
        AuthenticatedUser $authenticatedUser,
        Filesystem $filesystem,
        FileRepository $fileRepository
    ) {
        $this->authenticatedUser = $authenticatedUser;
        $this->filesystem = $filesystem;
        $this->fileRepository = $fileRepository;
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

        /** @var UploadedFileInterface $uploadedFile */
        $uploadedFile = $request->getUploadedFiles()['file'];

        $file = new File(
            $this->authenticatedUser->getUser()->getId(),
            $uploadedFile->getClientFilename(),
            $uploadedFile->getClientMediaType(),
            $uploadedFile->getSize(),
            md5($uploadedFile->getStream()->getContents()) // To be optimized
        );

        if (!$this->filesystem->putStream($file->getPath(), $uploadedFile->getStream()->detach())) {
            return $response->withStatus(StatusCode::BAD_REQUEST);
        }

        try {
            $this->fileRepository->add($file);
        } catch (Exception $e) {
            $this->filesystem->delete($file->getPath());
            return $response->withStatus(StatusCode::BAD_REQUEST);
        }

        return $response->withJson([
            'data' => $file,
        ]);
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
