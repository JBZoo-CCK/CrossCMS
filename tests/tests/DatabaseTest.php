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
use JBZoo\SqlBuilder\Query\Select;

/**
 * Class DatabaseTest
 * @package JBZoo\PHPUnit
 */
class DatabaseTest extends CrossCMS
{
    protected function setUp()
    {
        parent::setUp();

        $sql = "CREATE TABLE IF NOT EXISTS `#__jbzoo` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(80) DEFAULT NULL,
              PRIMARY KEY (`id`)
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB;";

        $this->_getDb()->query($sql);
    }

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

        isSame(array(array('pi' => '3.141593')), $db->fetchAll($select));
        isSame(array('pi' => '3.141593'), $db->fetchRow($select));
        isSame(array('3.141593'), $db->fetchArray($select));
        isSame(1, $db->query($select));
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

        isSame(0, $db->insertId());
    }

    public function testEscape()
    {
        $db = $this->_getDb();

        isSame(' abc123-+\\\'\"` ', $db->escape(' abc123-+\'"` '));
    }

    public function testPrefix()
    {
        $db = $this->_getDb();

        isTrue(strlen($db->getPrefix()) > 0);
    }

    /**
     * @expectedException Exception
     */
    public function testInvalidQuery()
    {
        $cms = Cms::getInstance();
        if ($cms['type'] == Cms::TYPE_WORDPRESS) {
            skip('Stupid Wordpress can\'t handle exceptions...');
        }

        $db     = $this->_getDb();
        $select = new Select('information_schema.qwerty123');
        $db->fetchRow($select);
    }

    public function testGetTableColumnsOnlyType()
    {
        $fields = $this->_getDb()->getTableColumns('#__jbzoo', true);
        isSame(array(
            "id"    => "int unsigned",
            "title" => "varchar",
        ), $fields);
    }

    public function testGetTableColumnsFull()
    {
        $fields = $this->_getDb()->getTableColumns('#__jbzoo', false);
        isSame(array(
            'id'    => array(
                'Field'      => 'id',
                'Type'       => 'int(10) unsigned',
                'Collation'  => null,
                'Null'       => 'NO',
                'Key'        => 'PRI',
                'Default'    => null,
                'Extra'      => 'auto_increment',
                'Privileges' => 'select,insert,update,references',
                'Comment'    => '',
            ),
            'title' => array(
                'Field'      => 'title',
                'Type'       => 'varchar(80)',
                'Collation'  => 'utf8_general_ci',
                'Null'       => 'YES',
                'Key'        => '',
                'Default'    => null,
                'Extra'      => '',
                'Privileges' => 'select,insert,update,references',
                'Comment'    => '',
            )
        ), $fields);
    }
}
