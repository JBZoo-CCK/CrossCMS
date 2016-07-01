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

namespace JBZoo\CrossCMS\Joomla;

use JBZoo\CrossCMS\AbstractDate;
use JBZoo\Utils\Dates;

/**
 * Class Date
 * @package JBZoo\CrossCMS
 */
class Date extends AbstractDate
{
    /**
     * {@inheritdoc}
     */
    public function format($date = null, $format = self::SQL)
    {
        if (($date === Dates::SQL_NULL || null === $date) && $format == self::SQL) {
            return Dates::SQL_NULL;
        }

        $date = new \JDate($date);

        $format = trim($format);
        $format = $this->getFormat($format);

        if ($format === self::TIMESTAMP) {
            return $date->getTimestamp();
        }

        return $date->format($format);
    }
}
