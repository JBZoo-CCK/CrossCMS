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
        return call_user_func_array(array($this, '_printf'), func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    protected function _printf($message)
    {
        return call_user_func_array(array('JText', 'sprintf'), func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function plural($singular, $plural, $number)
    {
        $message = (1 === (int)$number) ? $singular : $plural;

        return $this->_printf($message, $number);
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        $tag    = \JFactory::getLanguage()->getTag();
        $result = explode('-', $tag);

        return $result[0];
    }
}
