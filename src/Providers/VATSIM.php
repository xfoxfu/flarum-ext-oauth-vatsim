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
        return 'https://auth.vatsim.net';
    }

    public function fields(): array
    {
        return [
            'client_id' => 'required',
            'client_secret' => 'required',
            'base_domain' => '',
        ];
    }

    public function provider(string $redirectUri): AbstractProvider
    {
        $options = [
            'clientId' => $this->getSetting('client_id'),
            'clientSecret' => $this->getSetting('client_secret'),
            'redirectUri' => $redirectUri,
        ];
        $domain = $this->getSetting('base_domain');

        if ($domain) {
            $options['domain'] = $domain;
        }

        return $this->provider = new VATSIMProvider($options);
    }

    public function suggestions(Registration $registration, $user, string $token)
    {
        /** @var VATSIMResourceOwner $user */
        $this->verifyEmail($email = $user->getEmail());

        $registration
            ->provideTrustedEmail($email)
            ->suggestUsername($user->getId() ?: '')
            ->setPayload($user->toArray());
    }
}
