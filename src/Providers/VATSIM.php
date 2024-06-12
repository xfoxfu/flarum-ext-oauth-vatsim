<?php

/*
 * This file is part of ianm/oauth-amazon.
 *
 * Copyright (c) 2021 IanM.
 *
 *  For the full copyright and license information, please view the LICENSE.md
 *  file that was distributed with this source code.
 */

namespace VATPRC\OAuthVATSIM\Providers;

use Flarum\Forum\Auth\Registration;
use FoF\OAuth\Provider;
use League\OAuth2\Client\Provider\AbstractProvider;

class VATSIM extends Provider
{
  public function name(): string
  {
    return 'vatsim';
  }

  public function link(): string
  {
    return 'https://my.vatsim.net/register';
  }

  public function fields(): array
  {
    return [
      'client_id' => 'required',
      'client_secret' => 'required',
    ];
  }

  public function provider(string $redirectUri): AbstractProvider
  {
    return $this->provider = new VATSIMProvider([
      'clientId' => $this->getSetting('client_id'),
      'clientSecret' => $this->getSetting('client_secret'),
      'redirectUri' => $redirectUri,
    ]);
  }

  public function suggestions(Registration $registration, $user, string $token)
  {
    /** @var VATSIMResourceOwner $user */
    $this->verifyEmail($email = $user->getEmail());

    $registration
      ->provideTrustedEmail($email)
      ->setPayload($user->toArray());
  }
}
