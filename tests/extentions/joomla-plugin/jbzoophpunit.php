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
    /**
     * @var bool
     */
    protected $_isInit = false;

    /**
     * @param object $subject The object to observe.
     * @param array  $config  An optional associative array of configuration settings.
     * @throws Exception
     */
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);

        // Include libs
        if (!$this->_request('jbzoo-phpunit')) {
            throw new Exception('JBZoo PHPUnit tests is not detected!');
        }
    }

    public function onAfterInitialise()
    {
    }

    public function onAfterRoute()
    {
    }

    public function onAfterDispatch()
    {
        $assets = Cms::_('assets');

        if ($test = $this->_request('test-assets-jsfile')) {
            $assets->jsFile($test . '.js');
        }

        if ($test = $this->_request('test-assets-jscode')) {
            $assets->jsCode($test);
        }

        
        if ($test = $this->_request('test-assets-cssfile')) {
            $assets->cssFile($test . '.css');
        }

        if ($test = $this->_request('test-assets-csscode')) {
            $assets->cssCode($test);
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
