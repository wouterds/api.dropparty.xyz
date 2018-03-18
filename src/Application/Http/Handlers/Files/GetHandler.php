<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers\Files;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Stream;
use Teapot\StatusCode;
use WouterDeSchuyter\DropParty\Domain\Files\FileId;
use WouterDeSchuyter\DropParty\Domain\Files\FileRepository;
use WouterDeSchuyter\DropParty\Domain\Users\UserRepository;
use WouterDeSchuyter\DropParty\Infrastructure\Filesystem\Filesystem;

class GetHandler
{
    /**
     * @var FileRepository
     */
    private $fileRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param FileRepository $fileRepository
     * @param UserRepository $userRepository
     */
    public function __construct(FileRepository $fileRepository, UserRepository $userRepository)
    {
        $this->fileRepository = $fileRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        // No file id passed?
        if (empty($request->getParam('id'))) {
            return $response->withStatus(StatusCode::NOT_FOUND);
        }

        // Try to get file
        $file = $this->fileRepository->getById(new FileId($request->getParam('id')));

        // File not found?
        if (empty($file)) {
            return $response->withStatus(StatusCode::NOT_FOUND);
        }

        // Get user
        $user = $this->userRepository->getById($file->getUserId());

        // Init filesystem for user
        $filesystem = Filesystem::fromUser($user);

        // Get resource
        $resource = $filesystem->readStream($file->getPath());

        // Create stream from resource
        $stream = new Stream($resource);

        // Build response
        $response = $response->withBody($stream);
        $response = $response->withHeader('Content-Length', $file->getSize());
        $response = $response->withHeader('Content-Type', $file->getContentType());

        return $response;
    }
}
