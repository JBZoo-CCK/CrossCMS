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

namespace JBZoo\PHPUnit;

use JBZoo\CrossCMS\Cms;

/**
 * Class EnvTest
 * @package JBZoo\PHPUnit
 */
class EnvTest extends CrossCMS
{
    public function test()
    {
        $cms = Cms::getInstance();

        $version = $cms['env']->getVersion();

        isTrue(version_compare('1.0.0', $version, '<'));

        isFalse($cms['env']->isAdmin());
        isTrue($cms['env']->isSite());
        isTrue($cms['env']->isCli());
    }
}
