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
 * Class ConfigTest
 * @package JBZoo\PHPUnit
 */
class ConfigTest extends PHPUnit
{
    public function testConfig()
    {
        $config = Cms::_('config');

        isTrue(is_bool($config->isDebug()));

        isTrue(is_string($config->sitename()));
        isTrue(is_string($config->sitedesc()));
        isTrue(is_string($config->email()));
        isTrue(is_string($config->dbHost()));
        isTrue(is_string($config->dbName()));
        isTrue(is_string($config->dbUser()));
        isTrue(is_string($config->dbPass()));
        isTrue(is_string($config->dbPrefix()));
        isTrue(is_string($config->dbType()));
        isTrue(is_string($config->timezone()));
    }

}
