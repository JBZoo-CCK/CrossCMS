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

namespace JBZoo\CrossCMS\Wordpress;

/**
 * Class Wordpress
 * @package JBZoo\CrossCMS
 */
class Wordpress
{
    /**
     * {@inheritdoc}
     */
    public static function check()
    {
        return defined('ABSPATH') && ABSPATH;
    }
}