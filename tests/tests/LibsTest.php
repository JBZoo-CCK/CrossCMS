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
class LibsTest extends PHPUnit
{

    public function testjQuery()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-libs-jquery' => 1));

        if (Cms::_('type') === CMS::TYPE_WORDPRESS) {
            isContain('wp-includes/js/jquery/jquery.js', $html);

        } elseif (Cms::_('type') === CMS::TYPE_JOOMLA) {
            isContain('media/jui/js/jquery.js', $html);
        }
    }

    public function testjQueryUI()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-libs-jqueryui' => 1));

        if (Cms::_('type') === CMS::TYPE_WORDPRESS) {
            isContain('wp-includes/js/jquery/ui/core.min.js', $html);
        } elseif (Cms::_('type') === CMS::TYPE_JOOMLA) {
            isContain('media/jui/js/jquery.ui.core.js', $html);
        }
    }

    public function testjQueryAutocomplete()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-libs-autocomplete' => 1));

        if (Cms::_('type') === CMS::TYPE_WORDPRESS) {
            isContain('wp-includes/js/jquery/ui/autocomplete.min.js', $html);
        } elseif (Cms::_('type') === CMS::TYPE_JOOMLA) {
            isContain('media/jui/js/jquery.autocomplete.js', $html);
        }
    }

    public function testjQueryDatePicker()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-libs-datepicker' => 1));

        if (Cms::_('type') === CMS::TYPE_WORDPRESS) {
            isContain('wp-includes/js/jquery/ui/datepicker.min.js', $html);
        } elseif (Cms::_('type') === CMS::TYPE_JOOMLA) {
            isContain('media/system/js/calendar', $html);
        }
    }

    public function testColorPicker()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-libs-colorpicker' => 1));

        if (Cms::_('type') === CMS::TYPE_WORDPRESS) {
            isContain('wp-includes/js/colorpicker.min.js', $html);
        } elseif (Cms::_('type') === CMS::TYPE_JOOMLA) {
            isContain('media/jui/js/jquery.minicolors.', $html);
        }
    }
}
