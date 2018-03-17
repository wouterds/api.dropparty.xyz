<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers;

use InvalidArgumentException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use RuntimeException;
use Slim\Http\Request;
use Slim\Http\Response;
use Teapot\StatusCode;

class AuthenticateVerifyTokenHandler
{
    /**
     * @param Request $request
     * @param Response $response
     * @param string $token
     * @return Response
     */
    public function __invoke(Request $request, Response $response, string $token): Response
    {
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

        return $response->withStatus(StatusCode::OK);
    }
}
