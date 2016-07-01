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

use JBZoo\Utils\Dates;

/**
 * Class AbstractDate
 * @package JBZoo\CrossCMS
 */
abstract class AbstractDate extends AbstractHelper
{
    const SQL       = 'sql';
    const TIMESTAMP = 'timestamp';
    const DETAIL    = 'detail';
    const FULL      = 'full';
    const LONG      = 'long';
    const MEDIUM    = 'medium';
    const SHORT     = 'short';
    const TIME      = 'time';

    protected $_formats = [
        self::SQL       => Dates::SQL_FORMAT,
        self::TIMESTAMP => 'timestamp',
        self::DETAIL    => 'l, M d Y H:i',
        self::FULL      => 'l, M d Y',
        self::LONG      => 'd F, Y',
        self::MEDIUM    => 'M d, Y',
        self::SHORT     => 'n/d/y',
        self::TIME      => 'H:i',
    ];

    /**
     * Formats a time/date.
     *
     * @param  mixed  $date
     * @param  string $format
     * @return string
     */
    abstract public function format($date = null, $format = self::SQL);

    /**
     * @return array
     */
    public function getFormats()
    {
        return $this->_formats;
    }

    /**
     * @param $formatName
     * @return string|null
     */
    public function getFormat($formatName)
    {
        $result = $formatName;

        if (isset($this->_formats[$formatName])) {
            $result = $this->_formats[$formatName];
        }

        return $result;
    }

    /**
     * @param array $formats
     */
    public function setFormats(array $formats)
    {
        $this->_formats = array_merge($this->_formats, $formats);
    }
}
