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
use JBZoo\SqlBuilder\Query\Select;

/**
 * Class DatabaseTest
 * @package JBZoo\PHPUnit
 */
class DatabaseTest extends PHPUnit
{
    /**
     * @return \JBZoo\CrossCMS\AbstractDatabase
     */
    protected function _getDb()
    {
        $cms = Cms::getInstance();
        return $cms['db'];
    }

    public function testFetches()
    {
        $db     = $this->_getDb();
        $select = 'SELECT PI() AS pi';

        same(array(array('pi' => '3.141593')), $db->fetchAll($select));
        same(array('pi' => '3.141593'), $db->fetchRow($select));
        same(array('3.141593'), $db->fetchArray($select));
        same(1, $db->query($select));
    }

    public function testSqlBuilder()
    {
        $db     = $this->_getDb();
        $select = new Select('information_schema.ENGINES');

        isTrue($db->query($select) > 1);
    }

    public function testInsertId()
    {
        $db = $this->_getDb();

        same(0, $db->insertId());
    }

    public function testEscape()
    {
        $db = $this->_getDb();

        same(' abc123-+\\\'\"` ', $db->escape(' abc123-+\'"` '));
    }

    public function testPrefix()
    {
        $db = $this->_getDb();

        isTrue(strlen($db->getPrefix()) > 0);
    }

}
