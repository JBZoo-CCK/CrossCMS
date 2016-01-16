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
 * Class RequestTest
 * @package JBZoo\PHPUnit
 */
class RequestTest extends PHPUnit
{

    public function testMethod()
    {
        is('GET', Cms::_('request')->getMethod());
    }

    public function testIsGet()
    {
        isTrue(Cms::_('request')->isGet());
    }

    public function testIsPost()
    {
        isFalse(Cms::_('request')->isPost());
    }

    public function testIsAjax()
    {
        isFalse(Cms::_('request')->isAjax());
    }

    public function testSet()
    {
        $req = Cms::_('request');

        $req->set('foo', '123456');

        isSame('123456', $_REQUEST['foo']);
        isSame('123456', $_GET['foo']);
        isSame('123456', $req->get('foo'));
    }

    public function testCheckEmptyToken()
    {
        //skip('TODO: Joomla fail test');
        //isFalse(Cms::_('request')->checkToken());
    }

    public function testGetUri()
    {
        isTrue(Cms::_('request')->getUri());
    }
}
