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
 * Class LangTest
 * @package JBZoo\PHPUnit
 */
class LangTest extends PHPUnit
{
    /**
     * @return \JBZoo\CrossCMS\AbstractLang
     */
    protected function _getLang()
    {
        $cms = Cms::getInstance();
        return $cms['lang'];
    }

    public function testTranslate()
    {
        $lang = $this->_getLang();
        isSame('January', $lang->translate('January'));
        isSame('Some undefined string 123456 QWERTY', $lang->translate('Some undefined string 123456 QWERTY'));
    }

    public function testSprintf()
    {
        $lang = $this->_getLang();

        if (Cms::_('type') === Cms::TYPE_WORDPRESS) {
            isSame('Comment: 42', $lang->translate('Comment: %s', 42));
            isSame('qwerty and 123456', $lang->translate('%s and %s', 'qwerty', 123456));

        } elseif (Cms::_('type') === Cms::TYPE_JOOMLA) {
            \JFactory::getLanguage()->load('lib_joomla', PROJECT_RES . '/joomla');
            isSame('Hits: 42', $lang->translate('JGLOBAL_HITS_COUNT', 42));
            isSame('Page 24 of 42', $lang->translate('JLIB_HTML_PAGE_CURRENT_OF_TOTAL', 24, 42));
        }
    }

    public function testPlural()
    {
        $lang = $this->_getLang();

        if (Cms::_('type') === Cms::TYPE_WORDPRESS) {
            isSame('0 months', $lang->plural('%s month', '%s months', 0));
            isSame('1 month', $lang->plural('%s month', '%s months', 1));
            isSame('2 months', $lang->plural('%s month', '%s months', 2));
            isSame('15 months', $lang->plural('%s month', '%s months', 15));

        } elseif (Cms::_('type') === Cms::TYPE_JOOMLA) {
            \JFactory::getLanguage()->load('mod_status', PROJECT_RES . '/joomla/administrator');
            isSame('0 Messages', $lang->plural('MOD_STATUS_MESSAGES_1', 'MOD_STATUS_MESSAGES_MORE', 0));
            isSame('1 Message', $lang->plural('MOD_STATUS_MESSAGES_1', 'MOD_STATUS_MESSAGES_MORE', 1));
            isSame('2 Messages', $lang->plural('MOD_STATUS_MESSAGES_1', 'MOD_STATUS_MESSAGES_MORE', 2));
            isSame('15 Messages', $lang->plural('MOD_STATUS_MESSAGES_1', 'MOD_STATUS_MESSAGES_MORE', 15));
        }
    }

    public function testCode()
    {
        $lang = $this->_getLang();

        isSame('en', $lang->getCode());

        if (Cms::_('type') === Cms::TYPE_WORDPRESS) {
            isSame('0 months', $lang->plural('%s month', '%s months', 0));
            isSame('1 month', $lang->plural('%s month', '%s months', 1));
            isSame('2 months', $lang->plural('%s month', '%s months', 2));
            isSame('15 months', $lang->plural('%s month', '%s months', 15));

        } elseif (Cms::_('type') === Cms::TYPE_JOOMLA) {
            isSame('en', $lang->getCode());
        }
    }
}
