<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Lcobucci\JWT\Builder;
use Slim\Http\Request;
use Slim\Http\Response;
use WouterDeSchuyter\DropParty\Application\Oauth\DropboxOauthProvider;
use WouterDeSchuyter\DropParty\Domain\Users\User;
use WouterDeSchuyter\DropParty\Domain\Users\UserRepository;

class AuthenticateHandler
{
    /**
     * @var DropboxOauthProvider
     */
    private $dropboxOauthProvider;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param DropboxOauthProvider $dropboxOauthProvider
     * @param UserRepository $userRepository
     */
    public function __construct(DropboxOauthProvider $dropboxOauthProvider, UserRepository $userRepository)
    {
        $this->dropboxOauthProvider = $dropboxOauthProvider;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        if (empty($request->getQueryParam('code'))) {
            return $response->withRedirect($this->dropboxOauthProvider->getAuthorizationUrl());
        }

        $accessToken = $this->dropboxOauthProvider->getAccessToken('authorization_code', [
            'code' => $request->getQueryParam('code'),
        ]);

        $resourceOwner = $this->dropboxOauthProvider->getResourceOwner($accessToken);

        $user = new User(
            $resourceOwner->getId(),
            $accessToken->getToken(),
            $resourceOwner->toArray()['email'],
            $resourceOwner->toArray()['name']['given_name'],
            $resourceOwner->toArray()['name']['surname']
        );

        try {
            $this->userRepository->add($user);
        } catch (UniqueConstraintViolationException $exception) {
            // User already exists, get by dropbox account id
            $user = $this->userRepository->getByDropboxAccountId($user->getDropboxAccountId());
        }

        // Generate JWT
        $token = new Builder();
        $token->setIssuer(getenv('APP_URL'));
        $token->setExpiration(time() + 60 * 60 * 24 * 7); // 1 week
        $token->set('user_id', $user->getId());
        $token->set('dropbox_account_id', $user->getDropboxAccountId());
        $token->set('first_name', $user->getFirstName());
        $token->set('name', $user->getName());
        $token->set('email', $user->getEmail());
        $token = $token->getToken();

        return $response->withRedirect(getenv('APP_FRONTEND_URL') . '/?token=' . $token);
    }
}
