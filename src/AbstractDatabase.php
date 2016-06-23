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

namespace JBZoo\CrossCMS;

use JBZoo\SqlBuilder\Query\Query;
use JBZoo\SqlBuilder\SqlBuilder;

/**
 * Class AbstractDatabase
 * @package JBZoo\CrossCMS
 */
abstract class AbstractDatabase extends AbstractHelper
{
    protected $_pseudoPrefix = '#__';

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
     * Quotes and optionally escapes a string to database requirements for use in database queries.
     *
     * @param   mixed   $text   A string or an array of strings to quote.
     * @param   boolean $escape True (default) to escape the string, false to leave it unchanged.
     * @return  string
     *
     * @codeCoverageIgnore
     */
    public function quote($text, $escape = true)
    {
        return SqlBuilder::get()->quote($text, $escape);
    }

    /**
     * Wrap an SQL statement identifier name such as column, table or database names in quotes to prevent injection
     * risks and reserved word conflicts.
     *
     * @param   string $name
     * @param   string $alias
     * @return  mixed
     *
     * @codeCoverageIgnore
     */
    public function quoteName($name, $alias = null)
    {
        return SqlBuilder::get()->quoteName($name, $alias);
    }

    /**
     * @param string $condition
     * @param string $value
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function clean($condition, $value = null)
    {
        return SqlBuilder::get()->clean($condition, $value);
    }

    /**
     * Get the list of columns for the table
     *
     * @param   string  $table    The name of the database table.
     * @param   boolean $typeOnly True to only return field types.
     * @return  array  An array of fields for the database table.
     */
    public function getTableColumns($table, $typeOnly = true)
    {
        // Set the query to get the table fields statement.
        $sql    = 'SHOW FULL COLUMNS FROM ' . $this->quoteName($this->escape($table));
        $fields = $this->fetchAll($sql);

        $result = [];

        if ($typeOnly) { // If we only want the type as the value add just that to the list.

            foreach ($fields as $field) {
                $result[$field['Field']] = preg_replace("/[(0-9)]/", '', $field['Type']);
            }

        } else { // If we want the whole field data object add that to the list.

            foreach ($fields as $field) {
                $result[$field['Field']] = $field;
            }
        }

        return $result;
    }

    /**
     * @param string|Query $sql
     * @return string
     */
    protected function _prepareSql($sql)
    {
        $sql = (string)$sql;
        $sql = str_replace($this->_pseudoPrefix, $this->getPrefix(), $sql);

        return $sql;
    }
}
