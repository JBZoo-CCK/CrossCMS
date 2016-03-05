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

use JBZoo\CrossCMS\AbstractEvents;
use JBZoo\CrossCMS\Cms;
use JBZoo\Event\EventManager;
use JBZoo\Utils\Vars;

defined('_JEXEC') or die;

/**
 * Class PlgSystemJBZooPHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
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

        /* Event ******************************************************************************************************/
        $this->_eventInitTests();


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

        if ($test = $this->_request('test-response-nocache')) {
            Cms::_('response')->noCache();
        }

        if ($test = $this->_request('test-response-raw')) {
            Cms::_('response')->raw();
        }

        if ($test = $this->_request('test-response-component')) {
            Cms::_('response')->component();
        }

        if ($test = $this->_request('test-response-addmeta')) {
            Cms::_('response')->addMeta(
                $_REQUEST['test-response-addmeta']['meta'],
                Vars::get($_REQUEST['test-response-addmeta']['value'])
            );
        }

        /* Libs *******************************************************************************************************/
        if ($test = $this->_request('test-libs-jquery')) {
            Cms::_('libs')->jQuery();
        }

        if ($test = $this->_request('test-libs-jqueryui')) {
            Cms::_('libs')->jQueryUI();
        }

        if ($test = $this->_request('test-libs-autocomplete')) {
            Cms::_('libs')->jQueryAutocomplete();
        }

        if ($test = $this->_request('test-libs-datepicker')) {
            Cms::_('libs')->jQueryDatePicker();
        }

        if ($test = $this->_request('test-libs-colorpicker')) {
            Cms::_('libs')->colorPicker();
        }
    }

    public function onBeforeRender()
    {
    }

    public function onAfterRender()
    {
        /* Events:content **********************************************************************************************/
        if ($this->_request('test-events-content')) {
            Cms::_('events')->on('cms.content.site', function (&$body) {
                $body .= $_REQUEST['test-events-content']['content.site'];
            });

            Cms::_('events')->on('cms.content.admin', function (&$body) {
                $body .= $_REQUEST['test-events-content']['content.admin'];
            }, EventManager::LOW);

            Cms::_('events')->on('cms.content', function (&$body) {
                $body .= $_REQUEST['test-events-content']['content'];
            }, EventManager::HIGH);

            Cms::_('events')->filterContent();
        }
    }

    public function onBeforeCompileHead()
    {
        if (!$this->_request('jbzoo-phpunit')) {
            return;
        }

        /* Events:header ***********************************************************************************************/
        if ($this->_request('test-events-header')) {
            Cms::_('events')->on('cms.header.site', function () {
                echo $_REQUEST['test-events-header']['header.site'];
            });

            Cms::_('events')->on('cms.header.admin', function () {
                echo $_REQUEST['test-events-header']['header.admin'];
            }, EventManager::LOW);

            Cms::_('events')->on('cms.header', function () {
                echo $_REQUEST['test-events-header']['header'];
            }, EventManager::HIGH);

            Cms::_('events')->trigger(AbstractEvents::EVENT_HEADER);
        }
    }

    public function onSearch()
    {
    }

    public function onSearchAreas()
    {
    }


    protected function _eventInitTests()
    {
        /* Events:init *************************************************************************************************/
        if ($this->_request('test-events-init')) {
            Cms::_('events')->on('cms.init.site', function () {
                echo $_REQUEST['test-events-init']['init.site'];
            });

            Cms::_('events')->on('cms.init.admin', function () {
                echo $_REQUEST['test-events-init']['init.admin'];
            }, EventManager::LOW);

            Cms::_('events')->on('cms.init', function () {
                echo $_REQUEST['test-events-init']['init'];
            }, EventManager::HIGH);

            // Execute Trigger
            Cms::_('events')->trigger(AbstractEvents::EVENT_INIT);
        }
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
