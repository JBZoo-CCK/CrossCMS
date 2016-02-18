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

/**
 * Class EventTest
 * @package JBZoo\PHPUnit
 */
class EventTest extends PHPUnit
{
    public function testInit()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-event-init' => array(
            'init'       => '-qw-',
            'init.site'  => '-er-',
            'init.admin' => '-ty-',
        )));

        isContain('-qw--er-', $html);
    }

    public function testHeader()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-event-header' => array(
            'header'       => '-123-',
            'header.site'  => '-456-',
            'header.admin' => '-789-',
        )));

        isContain('-123--456-', $html);
    }

    public function testContent()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-event-content' => array(
            'content'       => '-ab-',
            'content.site'  => '-cd-',
            'content.admin' => '-ef-',
        )));

        isContain('-ab--cd-', $html);
    }
}
