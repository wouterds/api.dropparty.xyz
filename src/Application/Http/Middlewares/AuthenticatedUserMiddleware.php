<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Middlewares;

use Closure;
use InvalidArgumentException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use RuntimeException;
use Slim\Http\Request;
use Slim\Http\Response;
use Teapot\StatusCode;
use WouterDeSchuyter\DropParty\Domain\Users\AuthenticatedUser;
use WouterDeSchuyter\DropParty\Domain\Users\UserId;
use WouterDeSchuyter\DropParty\Domain\Users\UserRepository;

class AuthenticatedUserMiddleware
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var AuthenticatedUser
     */
    private $authenticatedUser;

    /**
     * @param UserRepository $userRepository
     * @param AuthenticatedUser $authenticatedUser
     */
    public function __construct(UserRepository $userRepository, AuthenticatedUser $authenticatedUser)
    {
        $this->userRepository = $userRepository;
        $this->authenticatedUser = $authenticatedUser;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param Closure $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next): Response
    {
        $token = $request->getHeaderLine('authorization');

        try {
            $token = (new Parser())->parse((string) $token);
        } catch (InvalidArgumentException $e) {
            return $response->withStatus(StatusCode::UNAUTHORIZED);
        } catch (RuntimeException $e) {
            return $response->withStatus(StatusCode::UNAUTHORIZED);
        }

        $signer = new Sha512();
        if (!$token->verify($signer, getenv('JWT_SIGNING_KEY'))) {
            return $response->withStatus(StatusCode::UNAUTHORIZED);
        }

        $user = $this->userRepository->getById(new UserId($token->getClaim('user_id')));
        if (empty($user)) {
            return $response->withStatus(StatusCode::UNAUTHORIZED);
        }

        $this->authenticatedUser->setToken($token);
        $this->authenticatedUser->setUser($user);

        return $next($request, $response);
    }
}
