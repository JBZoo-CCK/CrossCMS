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
 * Class SessionTest
 * @package JBZoo\PHPUnit
 */
class SessionTest extends PHPUnit
{
    /**
     * @return \JBZoo\CrossCMS\AbstractSession
     */
    protected function _getSession()
    {
        $cms = Cms::getInstance();
        return $cms['session'];
    }

    public function testSetAndGet()
    {
        $session = $this->_getSession();

        $session->set('key', 123);
        is(123, $session->get('key'));

        $session->set('key', 456, 'other-group');
        is(456, $session->get('key', null, 'other-group'));

        $session->clear('key');
        isNull($session->get('key'));

        $session->clear('key', 'other-group');
        isNull($session->get('key', null, 'other-group'));

        isNull($session->get('key-undefined'));
        isNull($session->get('key-undefined', null, 'other-group'));

        is(456, $session->get('key-undefined', 456));
        is(456, $session->get('key-undefined', 456, 'other-group'));
    }

    public function testGroup()
    {
        $session = $this->_getSession();

        $session->setGroup('group', array('k' => 1, 'k2' => 2));
        isSame(array('k' => 1, 'k2' => 2), $session->getGroup('group'));

        $session->setGroup('group', array('k3' => 3), false);
        isSame(array('k' => 1, 'k2' => 2, 'k3' => 3), $session->getGroup('group'));

        $session->setGroup('group', array('k4' => 4), true);
        isSame(array('k4' => 4), $session->getGroup('group'));
    }

    public function testToken()
    {
        $session = $this->_getSession();
        isTrue(is_string($session->getToken()));
    }

}
