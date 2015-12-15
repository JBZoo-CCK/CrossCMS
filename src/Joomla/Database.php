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

namespace JBZoo\CrossCMS\Joomla;

use JBZoo\CrossCMS\AbstractDatabase;

/**
 * Class Database
 * @package JBZoo\CrossCMS
 */
class Database extends AbstractDatabase
{
    /**
     * @var \JDatabaseDriver
     */
    protected $_db = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_db = \JFactory::getDbo();
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->_db->getPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function query($sql)
    {
        $sql    = $this->_prepareSql($sql);
        $result = $this->_db->setQuery($sql)->execute();

        if (is_bool($result)) {
            return $result;
        }

        return $this->_db->getNumRows();
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($sql)
    {
        $sql    = $this->_prepareSql($sql);
        $result = $this->_db->setQuery($sql)->loadAssocList();
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchRow($sql)
    {
        $sql    = $this->_prepareSql($sql);
        $result = $this->_db->setQuery($sql)->loadAssoc();
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchArray($sql)
    {
        $sql    = $this->_prepareSql($sql);
        $result = $this->_db->setQuery($sql)->loadRow();
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function escape($text)
    {
        return $this->_db->escape($text);
    }

    /**
     * {@inheritdoc}
     */
    public function insertId()
    {
        return $this->_db->insertid();
    }
}
