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
 * Class PathTest
 * @package JBZoo\PHPUnit
 */
class PathTest extends PHPUnit
{
    /**
     * @param string $aliasPath
     * @param string $exceptPath
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
            array('root', PROJECT_RES . '/joomla'),
            array('upload', PROJECT_RES . '/joomla/images'),
            array('cache', PROJECT_RES . '/joomla/cache'),
            array('tmpl', PROJECT_RES . '/joomla/templates'),
            array('logs', PROJECT_RES . '/joomla/logs'),
            array('tmp', PROJECT_RES . '/joomla/tmp'),
            array('crosscms', './src'),
        );
    }

    /**
     * @param string $aliasPath
     * @param string $exceptPath
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
            array('root', PROJECT_RES . '/wordpress'),
            array('upload', PROJECT_RES . '/wordpress/wp-content/uploads'),
            array('tmpl', PROJECT_RES . '/wordpress/wp-content/themes'),
            array('cache', PROJECT_RES . '/wordpress/cache'),
            array('logs', PROJECT_RES . '/wordpress/logs'),
            array('tmp', PROJECT_RES . '/wordpress/tmp'),
            array('crosscms', './src'),
        );
    }
}
