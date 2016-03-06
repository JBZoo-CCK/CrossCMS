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
 * Class TestCms
 * @package JBZoo\PHPUnit
 */
class CmsTest extends CrossCMS
{

    public function testInit()
    {
        isClass('\JBZoo\CrossCMS\Cms', Cms::getInstance());
    }

    public function testInstances()
    {
        $cms = Cms::getInstance();

        $helpers = array(
            "db"       => '\JBZoo\CrossCMS\AbstractDatabase',
            "response" => '\JBZoo\CrossCMS\AbstractResponse',
            "session"  => '\JBZoo\CrossCMS\AbstractSession',
            "request"  => '\JBZoo\CrossCMS\AbstractRequest',
            "config"   => '\JBZoo\CrossCMS\AbstractConfig',
            "header"   => '\JBZoo\CrossCMS\AbstractHeader',
            "mailer"   => '\JBZoo\CrossCMS\AbstractMailer',
            "events"   => '\JBZoo\CrossCMS\AbstractEvents',
            "cache"    => '\JBZoo\CrossCMS\AbstractCache',
            "http"     => '\JBZoo\CrossCMS\AbstractHttp',
            "env"      => '\JBZoo\CrossCMS\AbstractEnv',
            "path"     => '\JBZoo\Path\Path',
        );

        foreach ($helpers as $key => $className) {
            isClass($className, $cms[$key]);
        }

    }
}
