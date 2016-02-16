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
    protected function setUp()
    {
        $_REQUEST = array();
        $_GET     = array();
        $_POST    = array();
        $_FILES   = array();
        $_COOKIE  = array();
    }

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
        Cms::_('request')->checkToken();
    }

    public function testGetUri()
    {
        isTrue(Cms::_('request')->getUri());
    }

    public function testGetUndefined()
    {
        $req = Cms::_('request');

        isNull($req->get('undefined'));
        isNull($req->get('undefined', null));
        isSame(123, $req->get('undefined', 123));
    }

    public function testGetFilterRaw()
    {
        $req = Cms::_('request');

        $req->set('foo', ' 123,456 ');

        isSame(' 123,456 ', $req->get('foo'));
        isSame(' 123,456 ', $req->get('foo', null));
        isSame(' 123,456 ', $req->get('foo', null, 'raw'));
        isSame('123,456', $req->get('foo', null, 'raw, trim'));
    }

    public function testGetFilterSeveral()
    {
        $req = Cms::_('request');

        $req->set('foo', '    <b>124.456</b> asd');

        isSame('124.456 asd', $req->get('foo', null, 'trim, strip'));
        isSame('124-456-asd', $req->get('foo', null, 'trim, alias'));
        isSame(124.0, $req->get('foo', null, 'trim, alias, float'));
        isSame(124, $req->get('foo', null, 'trim, float, int'));
        isSame('', $req->get('foo', null, 'trim, float, int, alpha'));
    }

    public function testGetFilterCustom()
    {
        $req = Cms::_('request');

        $req->set('foo', '    124-456');

        isSame('789-456', $req->get('foo', null, function ($value) {
            $value = trim($value);
            $value = str_replace('124', '789', $value);
            return $value;
        }));
    }

    public function testHeader()
    {
        $req = Cms::_('request');

        isSame('JBZoo PHPUnit Tester', $req->getHeader('user_agent'));
        isSame('jbzoo-phpunit-tester', $req->getHeader('user_agent', 'null', 'alias'));
        isSame('value', $req->getHeader('undefined', 'value'));
        isSame('value123', $req->getHeader('undefined', 'value', function ($value) {
            return $value . '123';
        }));
    }
}
