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
 * Class TestCms
 * @package JBZoo\PHPUnit
 */
class TestCms extends PHPUnit
{

    public function testInit()
    {
        isClass('\JBZoo\CrossCMS\Cms', Cms::getInstance());
    }

    public function testInstances()
    {
        $cms = Cms::getInstance();

        isClass('\JBZoo\CrossCMS\AbstractSession', $cms['session']);
        isClass('\JBZoo\CrossCMS\AbstractConfig', $cms['config']);
        isClass('\JBZoo\CrossCMS\AbstractDatabase', $cms['db']);
        isClass('\JBZoo\CrossCMS\AbstractEnv', $cms['env']);
        isClass('\JBZoo\Path\Path', $cms['path']);
    }
}
