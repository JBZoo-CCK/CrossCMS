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

/**
 * Class LibsTest
 * @package JBZoo\PHPUnit
 */
class LibsTest extends CrossCMS
{
    public function testjQuery()
    {
        $result = $this->helper->runIsolatedCMS(__METHOD__, array('test-libs-jquery' => 1));

        if ($this->_cms['type'] === Cms::TYPE_WORDPRESS) {
            isContain('wp-includes/js/jquery/jquery.js', $result->body);

        } elseif ($this->_cms['type'] === Cms::TYPE_JOOMLA) {
            isContain('media/jui/js/jquery.js', $result->body);
        }
    }

    public function testjQueryUI()
    {
        $result = $this->helper->runIsolatedCMS(__METHOD__, array('test-libs-jqueryui' => 1));

        if ($this->_cms['type'] === Cms::TYPE_WORDPRESS) {
            isContain('wp-includes/js/jquery/ui/core.min.js', $result->body);
        } elseif ($this->_cms['type'] === Cms::TYPE_JOOMLA) {
            isContain('media/jui/js/jquery.ui.core.js', $result->body);
        }
    }

    public function testjQueryAutocomplete()
    {
        $result = $this->helper->runIsolatedCMS(__METHOD__, array('test-libs-autocomplete' => 1));

        if ($this->_cms['type'] === Cms::TYPE_WORDPRESS) {
            isContain('wp-includes/js/jquery/ui/autocomplete.min.js', $result->body);
        } elseif ($this->_cms['type'] === Cms::TYPE_JOOMLA) {
            isContain('media/jui/js/jquery.autocomplete.js', $result->body);
        }
    }

    public function testjQueryDatePicker()
    {
        $result = $this->helper->runIsolatedCMS(__METHOD__, array('test-libs-datepicker' => 1));

        if ($this->_cms['type'] === Cms::TYPE_WORDPRESS) {
            isContain('wp-includes/js/jquery/ui/datepicker.min.js', $result->body);
        } elseif ($this->_cms['type'] === Cms::TYPE_JOOMLA) {
            isContain('media/system/js/calendar', $result->body);
        }
    }

    public function testColorPicker()
    {
        $result = $this->helper->runIsolatedCMS(__METHOD__, array('test-libs-colorpicker' => 1));

        if ($this->_cms['type'] === Cms::TYPE_WORDPRESS) {
            isContain('wp-includes/js/colorpicker.min.js', $result->body);
        } elseif ($this->_cms['type'] === Cms::TYPE_JOOMLA) {
            isContain('media/jui/js/jquery.minicolors.', $result->body);
        }
    }
}
