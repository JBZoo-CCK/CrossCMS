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
 */

namespace PHPSTORM_META {

    /** @noinspection PhpUnusedLocalVariableInspection */
    /** @noinspection PhpIllegalArrayKeyTypeInspection */

    $STATIC_METHOD_TYPES = [

        new \JBZoo\CrossCMS\Cms    => [
            "session" instanceof \JBZoo\CrossCMS\AbstractSession,
            "db" instanceof \JBZoo\CrossCMS\AbstractDatabase,
            "config" instanceof \JBZoo\CrossCMS\AbstractConfig,
        ],

        \JBZoo\CrossCMS\Cms::_('') => [
            "session" instanceof \JBZoo\CrossCMS\AbstractSession,
            "db" instanceof \JBZoo\CrossCMS\AbstractDatabase,
            "config" instanceof \JBZoo\CrossCMS\AbstractConfig,
        ],
    ];
}
