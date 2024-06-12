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

  /**
   * Returns the base URL for authorizing a client.
   *
   * @return string
   */
  public function getBaseAuthorizationUrl()
  {
    return 'https://auth-dev.vatsim.net/oauth/authorize';
  }

  /**
   * Returns the base URL for requesting an access token.
   *
   * @param array $params
   * @return string
   */
  public function getBaseAccessTokenUrl(array $params)
  {
    return 'https://auth-dev.vatsim.net/oauth/token';
  }

  /**
   * Returns the URL for requesting the resource owner's details.
   *
   * @param AccessToken $token
   * @return string
   */
  public function getResourceOwnerDetailsUrl(AccessToken $token)
  {
    return 'https://auth-dev.vatsim.net/api/user';
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
   * @throws IdentityProviderException
   * @param  ResponseInterface $response
   * @param  array|string $data Parsed response data
   * @return void
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
   * @param  array $response
   * @param  AccessToken $token
   * @return ResourceOwnerInterface
   */
  protected function createResourceOwner(array $response, AccessToken $token)
  {
    return new VATSIMResourceOwner($response);
  }

  /**
   * @param  mixed|null $token Either a string or an access token instance
   * @return array
   */
  protected function getAuthorizationHeaders($token = null)
  {
    return [
      'Authorization' => "Bearer {$token}",
    ];
  }
}
