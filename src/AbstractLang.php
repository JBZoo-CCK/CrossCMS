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
 * Class AbstractLang
 * @package JBZoo\CrossCMS
 */
abstract class AbstractLang
{
    /**
     * @param string $message
     * @return string
     */
    abstract protected function _translate($message);

    /**
     * @param string $message
     * @return string
     */
    abstract protected function _printf($message);

    /**
     * @param string $singular
     * @param string $plural
     * @param int    $number
     * @return string
     */
    abstract public function plural($singular, $plural, $number);

    /**
     * @return string
     */
    abstract public function getCode();

    /**
     * @param string $message
     * @return mixed
     */
    public function translate($message)
    {
        $args = func_get_args();

        if (strpos($message, '%s') !== false && count($args) >= 2) {
            return call_user_func_array(array($this, '_printf'), $args);
        }

        return call_user_func_array(array($this, '_translate'), $args);
    }
}
