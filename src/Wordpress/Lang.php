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

use JBZoo\CrossCMS\AbstractLang;

/**
 * Class Lang
 * @package JBZoo\CrossCMS
 */
class Lang extends AbstractLang
{
    /**
     * {@inheritdoc}
     */
    protected function _translate($message)
    {
        return translate($message);
    }

    /**
     * {@inheritdoc}
     */
    protected function _printf($message)
    {
        $args    = func_get_args();
        $args[0] = esc_html__($args[0]);

        return call_user_func_array('sprintf', $args);
    }

    /**
     * {@inheritdoc}
     */
    public function plural($singular, $plural, $number)
    {
        $message = _n($singular, $plural, $number);
        $message = esc_html($message);
        $message = sprintf($message, $number);

        return $message;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        $result = explode('_', get_locale());

        return $result[0];
    }
}
