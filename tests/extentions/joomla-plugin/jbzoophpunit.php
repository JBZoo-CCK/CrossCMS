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

use JBZoo\CrossCMS\Cms;

defined('_JEXEC') or die;

/**
 * Class PlgSystemJBZooPHPUnit
 */
class PlgSystemJBZooPHPUnit extends JPlugin
{
    public function onAfterInitialise()
    {
        if (!class_exists('\JBZoo\CrossCMS\Cms')) {
            if ($autoloadPath = realpath('../../vendor/autoload.php')) {
                require_once $autoloadPath;
            }
        }
    }

    public function onAfterRoute()
    {
    }

    public function onAfterDispatch()
    {
        if (!$this->_request('jbzoo-phpunit')) {
            return false;
        }

        /* Assets *****************************************************************************************************/
        if ($test = $this->_request('test-assets-jsfile')) {
            Cms::_('assets')->jsFile($test . '.js');
        }

        if ($test = $this->_request('test-assets-jscode')) {
            Cms::_('assets')->jsCode($test);
        }

        if ($test = $this->_request('test-assets-cssfile')) {
            Cms::_('assets')->cssFile($test . '.css');
        }

        if ($test = $this->_request('test-assets-csscode')) {
            Cms::_('assets')->cssCode($test);
        }

        /* Response ***************************************************************************************************/
        if ($test = $this->_request('test-response-set404')) {
            Cms::_('response')->set404();
        }

        if ($test = $this->_request('test-response-set500')) {
            Cms::_('response')->set500($test);
        }

        if ($test = $this->_request('test-response-redirect')) {
            Cms::_('response')->redirect($test);
        }

        if ($test = $this->_request('test-response-json')) {
            Cms::_('response')->json((array)$test, true);
        }

        if ($test = $this->_request('test-response-text')) {
            Cms::_('response')->text();
        }

        if ($test = $this->_request('test-response-title')) {
            Cms::_('response')->setTitle($test);
        }

        if ($test = $this->_request('test-response-keywords')) {
            Cms::_('response')->setKeywords($test);
        }

        if ($test = $this->_request('test-response-description')) {
            Cms::_('response')->setDesc($test);
        }

        if ($test = $this->_request('test-response-noindex')) {
            Cms::_('response')->noindex();
        }
    }

    public function onBeforeRender()
    {
    }

    public function onAfterRender()
    {
    }

    public function onBeforeCompileHead()
    {
    }

    public function onSearch()
    {
    }

    public function onSearchAreas()
    {
    }

    /**
     * @param string $valueName
     * @param mixed  $default
     * @return mixed
     * @throws Exception
     */
    protected function _request($valueName, $default = null)
    {
        $jInput = JFactory::getApplication()->input;
        $value  = $jInput->get($valueName, $default, false);

        return $value;
    }
}
