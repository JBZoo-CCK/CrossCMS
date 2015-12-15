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

namespace JBZoo\CrossCMS;

use JBZoo\SqlBuilder\Query\Query;

/**
 * Class AbstractDatabase
 * @package JBZoo\CrossCMS
 */
abstract class AbstractDatabase
{
    /**
     * @return string
     */
    abstract public function getPrefix();

    /**
     * @param  string|Query $sql
     * @return int|bool
     */
    abstract public function query($sql);

    /**
     * @param  string|Query $sql
     * @return mixed
     */
    abstract public function fetchAll($sql);

    /**
     * @param  string|Query $sql
     * @return mixed
     */
    abstract public function fetchRow($sql);

    /**
     * @param  string|Query $sql
     * @return mixed
     */
    abstract public function fetchArray($sql);

    /**
     * @param  string $text
     * @return mixed
     */
    abstract public function escape($text);

    /**
     * @return int
     */
    abstract public function insertId();

    /**
     * @param string|Query $sql
     * @return string
     */
    protected function _prepareSql($sql)
    {
        return (string)$sql;
    }
}
