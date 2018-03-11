<?php

namespace WouterDeSchuyter\DropParty\Application\Http\Handlers;

use Slim\Http\Request;
use Slim\Http\Response;
use WouterDeSchuyter\DropParty\Application\Oauth\DropboxOauthProvider;

class AuthenticateHandler
{
    /**
     * @var DropboxOauthProvider
     */
    private $dropboxOauthProvider;

    public function __construct(DropboxOauthProvider $dropboxOauthProvider)
    {
        $this->dropboxOauthProvider = $dropboxOauthProvider;
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
    }
}
