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

namespace JBZoo\PHPUnit;

use JBZoo\CrossCMS\Cms;

/**
 * Class EnvTest
 * @package JBZoo\PHPUnit
 */
class EnvTest extends PHPUnit
{
    public function test()
    {
        $env = Cms::_('env');

        $version = $env->getVersion();

        isTrue(version_compare('1.0.0', $version, '<'));

        isFalse($env->isAdmin());
        isTrue($env->isSite());
        isTrue($env->isCli());

    }

}
