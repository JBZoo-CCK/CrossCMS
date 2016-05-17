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
 * Class RequestTest
 * @package JBZoo\PHPUnit
 */
class RequestTest extends CrossCMS
{
    protected function setUp()
    {
        parent::setUp();

        $_REQUEST = array();
        $_GET     = array();
        $_POST    = array();
        $_FILES   = array();
        $_COOKIE  = array();
    }

    public function testMethod()
    {
        is('GET', $this->_cms['request']->getMethod());
    }

    public function testIsGet()
    {
        isTrue($this->_cms['request']->isGet());
    }

    public function testIsPost()
    {
        isFalse($this->_cms['request']->isPost());
    }

    public function testIsAjax()
    {
        isFalse($this->_cms['request']->isAjax());

        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        isTrue($this->_cms['request']->isAjax());
    }

    public function testSet()
    {
        $req = $this->_cms['request'];

        $req->set('foo', '123456');

        isSame('123456', $_REQUEST['foo']);
        isSame('123456', $_GET['foo']);
        isSame('123456', $req->get('foo'));
    }

    public function testGetArray()
    {
        $req = $this->_cms['request'];

        $req->set('arr', [
            'key_1'  => 'value_1',
            'nested' => [
                'key_2' => 'value_2'
            ]
        ]);

        isSame('123456', $_REQUEST['foo']);
        isSame('123456', $_GET['foo']);
        isSame('123456', $req->get('foo'));
    }

    public function testGetAndSetArray()
    {
        $req = $this->_cms['request'];

        $data = [
            'key_1'  => 'value_1',
            'nested' => [
                'key_2' => 'value_2'
            ]
        ];

        $req->set('arr', $data);

        isSame($data, $req->get('arr', [], 'arr'));
        isClass('\JBZoo\Data\Data', $req->getArray('arr'));
        isSame($data, (array)$req->getArray('arr'));

        $data['qwe'] = 'rty';
        isSame($data, (array)$req->getArray('arr', null, function ($value) {
            $value['qwe'] = 'rty';
            return $value;
        }));

        isSame('value_2', $req->getArray('arr')->find('nested.key_2'));
    }

    public function testCheckEmptyToken()
    {
        //skip('TODO: Joomla fail test');
        //$this->_cms['request']->checkToken();
    }

    public function testGetUri()
    {
        isTrue($this->_cms['request']->getUri());
    }

    public function testGetUndefined()
    {
        $req = $this->_cms['request'];

        isNull($req->get('undefined'));
        isNull($req->get('undefined', null));
        isSame(123, $req->get('undefined', 123));
    }

    public function testGetFilterRaw()
    {
        $req = $this->_cms['request'];

        $req->set('foo', ' 123,456 ');

        isSame(' 123,456 ', $req->get('foo'));
        isSame(' 123,456 ', $req->get('foo', null));
        isSame(' 123,456 ', $req->get('foo', null, 'raw'));
        isSame('123,456', $req->get('foo', null, 'raw, trim'));
    }

    public function testGetFilterSeveral()
    {
        $req = $this->_cms['request'];

        $req->set('foo', '    <b>124.456</b> asd');

        isSame('124.456 asd', $req->get('foo', null, 'trim, strip'));
        isSame('124-456-asd', $req->get('foo', null, 'trim, alias'));
        isSame(124.0, $req->get('foo', null, 'trim, alias, float'));
        isSame(124, $req->get('foo', null, 'trim, float, int'));
        isSame('', $req->get('foo', null, 'trim, float, int, alpha'));
    }

    public function testGetFilterCustom()
    {
        $req = $this->_cms['request'];

        $req->set('foo', '    124-456');

        isSame('789-456', $req->get('foo', null, function ($value) {
            $value = trim($value);
            $value = str_replace('124', '789', $value);
            return $value;
        }));
    }

    public function testHeader()
    {
        $req = $this->_cms['request'];

        isSame('JBZoo PHPUnit Tester', $req->getHeader('user_agent'));
        isSame('jbzoo-phpunit-tester', $req->getHeader('user_agent', 'null', 'alias'));
        isSame('value', $req->getHeader('undefined', 'value'));
        isSame('value123', $req->getHeader('undefined', 'value', function ($value) {
            return $value . '123';
        }));
    }
}
