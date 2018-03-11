<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers;

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

    public function __construct(DropboxOauthProvider $dropboxOauthProvider, UserRepository $userRepository)
    {
        $this->dropboxOauthProvider = $dropboxOauthProvider;
        $this->userRepository = $userRepository;
    }

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

        $this->userRepository->add($user);
    }
}
