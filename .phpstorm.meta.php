<?php
/**
 * JBZoo CrossCMS
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   CrossCMS
 * @license   MIT
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      https://github.com/JBZoo/CrossCMS
 * @author    Denis Smetannikov <denis@jbzoo.com>
 */

namespace PHPSTORM_META {

    /** @noinspection PhpUnusedLocalVariableInspection */
    /** @noinspection PhpIllegalArrayKeyTypeInspection */

    $STATIC_METHOD_TYPES = [

        \JBZoo\CrossCMS\Cms::_('') => [
            "db"        instanceof \JBZoo\CrossCMS\AbstractDatabase,
            "response"  instanceof \JBZoo\CrossCMS\AbstractResponse,
            "session"   instanceof \JBZoo\CrossCMS\AbstractSession,
            "request"   instanceof \JBZoo\CrossCMS\AbstractRequest,
            "config"    instanceof \JBZoo\CrossCMS\AbstractConfig,
            "assets"    instanceof \JBZoo\CrossCMS\AbstractAssets,
            "mailer"    instanceof \JBZoo\CrossCMS\AbstractMailer,
            "event"     instanceof \JBZoo\CrossCMS\AbstractEvent,
            "cache"     instanceof \JBZoo\CrossCMS\AbstractCache,
            "http"      instanceof \JBZoo\CrossCMS\AbstractHttp,
            "lang"      instanceof \JBZoo\CrossCMS\AbstractLang,
            "user"      instanceof \JBZoo\CrossCMS\AbstractUser,
            "date"      instanceof \JBZoo\CrossCMS\AbstractDate,
            "env"       instanceof \JBZoo\CrossCMS\AbstractEnv,
            "path"      instanceof \JBZoo\Path\Path,
        ],
    ];
}
