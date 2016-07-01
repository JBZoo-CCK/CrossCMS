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
use JBZoo\Utils\Dates;

/**
 * Class UserTest
 * @package JBZoo\PHPUnit
 */
class DateTest extends CrossCMS
{
    /**
     * @return \JBZoo\CrossCMS\AbstractDate
     */
    protected function _getDate()
    {
        $cms = Cms::getInstance();
        return $cms['date'];
    }

    public function testFormats()
    {
        $date = $this->_getDate();

        $time = '1323738123'; // '2011-12-13 01:02:03'

        // Sql is default
        isTrue(Dates::toStamp($date->format()) > 0);
        isSame('2011-12-13 01:02:03', $date->format($time), 'default format');

        // System
        isSame('2011-12-13 01:02:03', $date->format($time, 'sql'), 'sql');
        isSame(1323738123, $date->format($time, 'timestamp'), 'timestamp');

        isSame('Tuesday, Dec 13 2011 01:02', $date->format($time, 'detail'), 'detail');
        isSame('Tuesday, Dec 13 2011', $date->format($time, 'full'), 'full');
        isSame('13 December, 2011', $date->format($time, 'long'), 'long');
        isSame('Dec 13, 2011', $date->format($time, 'medium'), 'medium');
        isSame('12/13/11', $date->format($time, 'short'), 'short');
        isSame('01:02', $date->format($time, 'time'), 'time');
    }
}
