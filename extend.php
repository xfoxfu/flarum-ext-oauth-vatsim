<?php

/*
 * This file is part of ianm/oauth-amazon.
 *
 * Copyright (c) 2021 IanM.
 *
 *  For the full copyright and license information, please view the LICENSE.md
 *  file that was distributed with this source code.
 */

namespace VATPRC\OAuthVATSIM;

use Flarum\Extend;
use FoF\OAuth\Extend as OAuthExtend;
use VATPRC\OAuthVATSIM\Providers\VATSIM;

return [
    (new Extend\Frontend('forum'))
        ->css(__DIR__ . '/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js'),

    new Extend\Locales(__DIR__ . '/locale'),

    (new OAuthExtend\RegisterProvider(VATSIM::class)),
];
