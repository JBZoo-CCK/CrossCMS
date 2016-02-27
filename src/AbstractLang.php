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

use JBZoo\Lang\Lang;

/**
 * Class AbstractLang
 * @package JBZoo\CrossCMS
 */
abstract class AbstractLang
{
    /**
     * @var Lang
     */
    protected $_lang;

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
        $args  = func_get_args();
        $count = count($args);

        // Try to find with JBZoo Language System
        /*
        if ($count === 1) {
            $result = $this->_lang->translate($message);
        } else {
            $args    = func_get_args();
            $args[0] = $this->_lang->translate($message);
            $result  = call_user_func_array('sprintf', $args);
        }

        if ($result && ($result !== $message)) {
            return $result;
        }
        */

        // Try to find with CMS Language System
        if (strpos($message, '%s') !== false && $count >= 2) {
            return call_user_func_array(array($this, '_printf'), $args);
        }

        return call_user_func_array(array($this, '_translate'), $args);
    }

    /**
     * @param Lang $lang
     */
    public function setCustomLang(Lang $lang)
    {
        if (null === $this->_lang) {
            $this->_lang = $lang;
        }
    }
}
