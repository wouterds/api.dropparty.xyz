<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers;

use InvalidArgumentException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use RuntimeException;
use Slim\Http\Request;
use Slim\Http\Response;
use Teapot\StatusCode;
use WouterDeSchuyter\DropParty\Domain\Users\UserId;
use WouterDeSchuyter\DropParty\Domain\Users\UserRepository;

class AuthVerifyTokenHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $token = $request->getParsedBodyParam('token');

        try {
            $token = (new Parser())->parse((string) $token);
        } catch (InvalidArgumentException $e) {
            return $response->withStatus(StatusCode::BAD_REQUEST);
        } catch (RuntimeException $e) {
            return $response->withStatus(StatusCode::BAD_REQUEST);
        }

        $signer = new Sha512();
        if (!$token->verify($signer, getenv('JWT_SIGNING_KEY'))) {
            return $response->withStatus(StatusCode::BAD_REQUEST);
        }

        $user = $this->userRepository->getById(new UserId($token->getClaim('user_id')));
        if (empty($user)) {
            return $response->withStatus(StatusCode::BAD_REQUEST);
        }

        return $response->withStatus(StatusCode::OK);
    }
}
