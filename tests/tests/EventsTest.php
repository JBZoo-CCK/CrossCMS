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
 * Class EventsTest
 * @package JBZoo\PHPUnit
 */
class EventsTest extends CrossCMS
{
    public function testGetEventManager()
    {
        $cms = Cms::getInstance();
        isClass('\JBZoo\Event\EventManager', $cms['events']->getManager());
    }

    public function testInit()
    {
        $result = Helper::runIsolatedCMS(__METHOD__, array('test-events-init' => array(
            'init'       => '-qw-',
            'init.site'  => '-er-',
            'init.admin' => '-ty-',
        )));

        isContain('-qw--er-', $result->body);
    }

    public function testHeader()
    {
        $result = Helper::runIsolatedCMS(__METHOD__, array('test-events-header' => array(
            'header'       => '-123-',
            'header.site'  => '-456-',
            'header.admin' => '-789-',
        )));

        isContain('-123--456-', $result->body);
    }

    public function testContent()
    {
        $result = Helper::runIsolatedCMS(__METHOD__, array('test-events-content' => array(
            'content'       => '-ab-',
            'content.site'  => '-cd-',
            'content.admin' => '-ef-',
        )));

        isContain('-ab--cd-', $result->body);
    }
}
