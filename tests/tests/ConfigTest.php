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
 * Class ConfigTest
 * @package JBZoo\PHPUnit
 */
class ConfigTest extends CrossCMS
{
    public function testConfig()
    {
        $cms = Cms::getInstance();

        isTrue(is_bool($cms['config']->isDebug()));

        isTrue(is_string($cms['config']->sitename()));
        isTrue(is_string($cms['config']->sitedesc()));
        isTrue(is_string($cms['config']->email()));
        isTrue(is_string($cms['config']->dbHost()));
        isTrue(is_string($cms['config']->dbName()));
        isTrue(is_string($cms['config']->dbUser()));
        isTrue(is_string($cms['config']->dbPass()));
        isTrue(is_string($cms['config']->dbPrefix()));
        isTrue(is_string($cms['config']->dbType()));
        isTrue(is_string($cms['config']->timezone()));
    }

}
