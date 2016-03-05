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

/**
 * Class AbstractDate
 * @package JBZoo\CrossCMS
 */
abstract class AbstractDate extends AbstractHelper
{

    protected $_formats = [
        'sql'       => 'Y-m-d H:i:s',
        'timestamp' => 'timestamp',
        'detail'    => 'l, M d Y H:i',
        'full'      => 'l, M d Y',
        'long'      => 'd F, Y',
        'medium'    => 'M d, Y',
        'short'     => 'n/d/y',
        'time'      => 'H:i',

    ];

    /**
     * Formats a time/date.
     *
     * @param  mixed  $date
     * @param  string $format
     * @return string
     */
    abstract public function format($date, $format = 'sql');

    /**
     * @return array
     */
    public function getFormats()
    {
        return $this->_formats;
    }

    /**
     * @param array $formats
     */
    public function setFormats(array $formats)
    {
        $this->_formats = array_merge($this->_formats, $formats);
    }
}
