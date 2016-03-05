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

use JBZoo\CrossCMS\AbstractLibs;
use JBZoo\CrossCMS\Cms;

/**
 * Class Assets
 * @package JBZoo\CrossCMS
 */
class Libs extends AbstractLibs
{
    /**
     * {@inheritdoc}
     */
    public function jQuery()
    {
        \JHtml::_('jquery.framework');
    }

    /**
     * {@inheritdoc}
     */
    public function jQueryUI()
    {
        \JHtml::_('jquery.ui');
    }

    /**
     * {@inheritdoc}
     */
    public function jQueryAutocomplete()
    {
        $isDebug = $this->_cms['config']->isDebug();
        \JHtml::_('script', 'jui/jquery.autocomplete.min.js', false, true, false, false, $isDebug);
    }

    /**
     * {@inheritdoc}
     */
    public function jQueryDatePicker()
    {
        \JHtml::_('behavior.calendar');
    }

    /**
     * {@inheritdoc}
     */
    public function colorPicker()
    {
        \JHtml::_('behavior.colorpicker');

    }
}
