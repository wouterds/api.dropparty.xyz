<?php

namespace WouterDeSchuyter\DropParty\Application\Oauth;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericResourceOwner;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class DropboxOauthProvider extends AbstractProvider
{
    public function getBaseAuthorizationUrl(): string
    {
        return 'https://www.dropbox.com/oauth2/authorize';
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return 'https://api.dropboxapi.com/oauth2/token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return 'https://api.dropboxapi.com/2/users/get_current_account';
    }

    protected function getAuthorizationHeaders($token = null): array
    {
        if ($token === null) {
            return [];
        }

        return ['Authorization' => 'Bearer ' . $token->getToken()];
    }

    public function getDefaultScopes(): array
    {
        return [];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() !== 200) {
            throw new IdentityProviderException('Unexpected response', $response->getStatusCode(), $response->getBody());
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token): GenericResourceOwner
    {
        return new GenericResourceOwner($response, 'account_id');
    }

    protected function getAuthorizationParameters(array $options): array
    {
        $parameters = parent::getAuthorizationParameters($options);

        // Unsupported param in Dropbox Oauth flow
        // If we don't remove it the endpoint complains about it
        if (isset($parameters['approval_prompt'])) {
            unset($parameters['approval_prompt']);
        }

        return $parameters;
    }

    protected function fetchResourceOwnerDetails(AccessToken $token): mixed
    {
        $url = $this->getResourceOwnerDetailsUrl($token);

        $request = $this->getAuthenticatedRequest(self::METHOD_POST, $url, $token);

        return $this->getParsedResponse($request);
    }
}
