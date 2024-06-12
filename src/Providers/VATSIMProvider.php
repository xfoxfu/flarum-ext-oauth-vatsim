<?php

namespace VATPRC\OAuthVATSIM\Providers;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class VATSIMProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    public const DEFAULT_DOMAIN = 'https://auth.vatsim.net';
    public string $domain = self::DEFAULT_DOMAIN;

    private const PATH_API_USER = '/api/user';
    private const PATH_AUTHORIZE = '/oauth/authorize';
    private const PATH_TOKEN = '/oauth/token';

    /**
     * Returns the base URL for authorizing a client.
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->domain . self::PATH_AUTHORIZE;
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->domain . self::PATH_TOKEN;
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->domain . self::PATH_API_USER;
    }

    /**
     * Returns the default scopes used by this provider.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [
            'full_name vatsim_details email'
        ];
    }

    /**
     * Checks a provider response for errors.
     *
     * @param ResponseInterface $response
     * @param array|string $data Parsed response data
     * @return void
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() != 200) {
            throw new VATSIMIdentityProviderException('unauthenticated', $response->getStatusCode(), $response);
        }
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new VATSIMResourceOwner($response);
    }
}
