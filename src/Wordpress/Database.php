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

namespace JBZoo\CrossCMS\Wordpress;

use JBZoo\CrossCMS\AbstractDatabase;
use JBZoo\CrossCMS\Cms;
use JBZoo\SqlBuilder\Query\Query;

/**
 * Class Database
 * @package JBZoo\CrossCMS
 */
class Database extends AbstractDatabase
{
    /**
     * @var \wpdb
     */
    protected $_db = null;

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function __construct(Cms $cms)
    {
        parent::__construct($cms);
        $this->_db = $GLOBALS['wpdb'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
        return $this->_db->get_blog_prefix();
    }

    /**
     * {@inheritdoc}
     */
    public function query($sql)
    {
        $sql    = $this->_prepareSql($sql);
        $result = $this->_db->query($sql);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($sql)
    {
        $sql    = $this->_prepareSql($sql);
        $result = $this->_db->get_results($sql, ARRAY_A);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchRow($sql)
    {
        $sql    = $this->_prepareSql($sql);
        $result = $this->_db->get_row($sql, ARRAY_A);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchArray($sql)
    {
        $sql    = $this->_prepareSql($sql);
        $result = $this->_db->get_row($sql, ARRAY_N);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function escape($text)
    {
        return $this->_db->_escape($text);
    }

    /**
     * {@inheritdoc}
     */
    public function insertId()
    {
        return $this->_db->insert_id;
    }
}
