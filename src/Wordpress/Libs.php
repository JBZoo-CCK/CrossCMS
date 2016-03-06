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

use JBZoo\CrossCMS\AbstractLibs;

/**
 * Class Libs
 * @package JBZoo\CrossCMS
 */
class Libs extends AbstractLibs
{
    /**
     * {@inheritdoc}
     */
    public function jQuery()
    {
        \wp_enqueue_script('jquery');
    }

    /**
     * {@inheritdoc}
     */
    public function jQueryUI()
    {
        \wp_enqueue_script('jquery-ui-core');
    }

    /**
     * {@inheritdoc}
     */
    public function jQueryAutocomplete()
    {
        \wp_enqueue_script('jquery-ui-autocomplete');
    }

    /**
     * {@inheritdoc}
     */
    public function jQueryDatePicker()
    {
        \wp_enqueue_script('jquery-ui-datepicker');
    }

    /**
     * {@inheritdoc}
     */
    public function colorPicker()
    {
        \wp_enqueue_script('colorpicker');
        \wp_enqueue_style('wp-color-picker');
    }
}
