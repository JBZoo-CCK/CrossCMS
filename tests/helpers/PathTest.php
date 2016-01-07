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
 * Class PathTest
 * @package JBZoo\PHPUnit
 */
class PathTest extends PHPUnit
{
    /**
     * @dataProvider providerJoomla
     */
    public function testJoomla($aliasPath, $exceptPath)
    {
        $cms = Cms::getInstance();

        if ($cms['type'] === Cms::TYPE_JOOMLA) {
            $path = Cms::_('path');
            isSame(realpath($exceptPath), realpath($path->get($aliasPath . ':')));
        }
    }

    public function providerJoomla()
    {
        return array(
            array('root', PROJECT_RESOURCES . '/joomla'),
            array('upload', PROJECT_RESOURCES . '/joomla/images'),
            array('cache', PROJECT_RESOURCES . '/joomla/cache'),
            array('tmpl', PROJECT_RESOURCES . '/joomla/templates'),
            array('logs', PROJECT_RESOURCES . '/joomla/logs'),
            array('tmp', PROJECT_RESOURCES . '/joomla/tmp'),
            array('crosscms', './src'),
        );
    }

    /**
     * @dataProvider providerWordpress
     */
    public function testWordpress($aliasPath, $exceptPath)
    {
        $cms = Cms::getInstance();

        if ($cms['type'] === Cms::TYPE_WORDPRESS) {
            $path = Cms::_('path');
            isSame(realpath($exceptPath), realpath($path->get($aliasPath . ':')));
        }
    }

    public function providerWordpress()
    {
        return array(
            array('root', PROJECT_RESOURCES . '/wordpress'),
            array('upload', PROJECT_RESOURCES . '/wordpress/wp-content/uploads'),
            array('tmpl', PROJECT_RESOURCES . '/wordpress/wp-content/themes'),
            //array('cache', PROJECT_RESOURCES . '/wordpress/cache'), // TODO JBZoo/Path WTF!!!
            //array('logs', PROJECT_RESOURCES . '/wordpress/logs'),
            //array('tmp', PROJECT_RESOURCES . '/wordpress/tmp'),
            array('crosscms', './src'),
        );
    }
}
