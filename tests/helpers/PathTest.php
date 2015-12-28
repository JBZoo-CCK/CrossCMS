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
     * @dataProvider providerPaths
     */
    public function testPaths($cmsType, $aliasPath, $exceptPath)
    {
        $cms = Cms::getInstance();

        if ($cms['type'] === $cmsType) {
            isSame(realpath($exceptPath), realpath($cms['path']->get($aliasPath . ':')), 'Path alias: ' . $aliasPath);
        }
    }

    public function providerPaths()
    {
        return array(
            // Joomla
            array(Cms::TYPE_JOOMLA, 'crosscms', '.'),
            array(Cms::TYPE_JOOMLA, 'root', PROJECT_RESOURCES . '/joomla'),
            array(Cms::TYPE_JOOMLA, 'upload', PROJECT_RESOURCES . '/joomla/images'),
            array(Cms::TYPE_JOOMLA, 'cache', PROJECT_RESOURCES . '/joomla/cache'),
            array(Cms::TYPE_JOOMLA, 'tmpl', PROJECT_RESOURCES . '/joomla/templates'),
            array(Cms::TYPE_JOOMLA, 'logs', PROJECT_RESOURCES . '/joomla/logs'),
            array(Cms::TYPE_JOOMLA, 'tmp', PROJECT_RESOURCES . '/joomla/tmp'),

            // Wordpress
            array(Cms::TYPE_WORDPRESS, 'crosscms', '.'),
            array(Cms::TYPE_WORDPRESS, 'root', PROJECT_RESOURCES . '/wordpress'),
            array(Cms::TYPE_WORDPRESS, 'upload', PROJECT_RESOURCES . '/wordpress/wp-content/uploads'),
            //array(Cms::TYPE_WORDPRESS, 'tmp', PROJECT_RESOURCES . '/wordpress/tmp'),
            //array(Cms::TYPE_WORDPRESS, 'logs', PROJECT_RESOURCES . '/wordpress/logs'),
            //array(Cms::TYPE_WORDPRESS, 'cache', PROJECT_RESOURCES . '/wordpress/cache'),
            //array(Cms::TYPE_WORDPRESS, 'tmpl', PROJECT_RESOURCES . '/wordpress/wp-content/themes'),
        );
    }
}
