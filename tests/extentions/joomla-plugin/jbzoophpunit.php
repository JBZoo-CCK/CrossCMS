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
    /**
     * @var Cms
     */
    protected $_cms;

    public function onAfterInitialise()
    {
        if (!class_exists('\JBZoo\CrossCMS\Cms')) {
            if ($autoloadPath = realpath('../../vendor/autoload.php')) {
                require_once $autoloadPath;
            }
        }

        $this->_cms = Cms::getInstance();


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

        /* Header *****************************************************************************************************/
        if ($test = $this->_request('test-header-title')) {
            $this->_cms['header']->setTitle($test);
        }

        if ($test = $this->_request('test-header-keywords')) {
            $this->_cms['header']->setKeywords($test);
        }

        if ($test = $this->_request('test-header-description')) {
            $this->_cms['header']->setDesc($test);
        }

        if ($test = $this->_request('test-header-noindex')) {
            $this->_cms['header']->noindex();
        }

        if ($test = $this->_request('test-header-jsfile')) {
            $this->_cms['header']->jsFile($test . '.js');
        }

        if ($test = $this->_request('test-header-cssfile')) {
            $this->_cms['header']->cssFile($test . '.css');
        }

        if ($test = $this->_request('test-header-jscode')) {
            $this->_cms['header']->jsCode($test);
        }

        if ($test = $this->_request('test-header-csscode')) {
            $this->_cms['header']->cssCode($test);
        }

        if ($test = $this->_request('test-header-addmeta')) {
            $this->_cms['header']->addMeta(
                $_REQUEST['test-header-addmeta']['meta'],
                Vars::get($_REQUEST['test-header-addmeta']['value'])
            );
        }

        /* Response ***************************************************************************************************/
        if ($test = $this->_request('test-response-set404')) {
            $this->_cms['response']->set404();
        }

        if ($test = $this->_request('test-response-set500')) {
            $this->_cms['response']->set500($test);
        }

        if ($test = $this->_request('test-response-redirect')) {
            $this->_cms['response']->redirect($test);
        }

        if ($test = $this->_request('test-response-json')) {
            $this->_cms['response']->json((array)$test, true);
        }

        if ($test = $this->_request('test-response-text')) {
            $this->_cms['response']->text();
        }

        if ($test = $this->_request('test-response-nocache')) {
            $this->_cms['response']->noCache();
        }

        if ($test = $this->_request('test-response-raw')) {
            $this->_cms['response']->raw();
        }

        if ($test = $this->_request('test-response-component')) {
            $this->_cms['response']->component();
        }

        /* Libs *******************************************************************************************************/
        if ($test = $this->_request('test-libs-jquery')) {
            $this->_cms['libs']->jQuery();
        }

        if ($test = $this->_request('test-libs-jqueryui')) {
            $this->_cms['libs']->jQueryUI();
        }

        if ($test = $this->_request('test-libs-autocomplete')) {
            $this->_cms['libs']->jQueryAutocomplete();
        }

        if ($test = $this->_request('test-libs-datepicker')) {
            $this->_cms['libs']->jQueryDatePicker();
        }

        if ($test = $this->_request('test-libs-colorpicker')) {
            $this->_cms['libs']->colorPicker();
        }
    }

    public function onBeforeRender()
    {
    }

    public function onAfterRender()
    {
        /* Events:content **********************************************************************************************/
        if ($this->_request('test-events-content')) {
            $this->_cms->on('cms.content.site', function (Cms $app, &$body) {
                $body .= $_REQUEST['test-events-content']['content.site'];
            });

            $this->_cms->on('cms.content.admin', function (Cms $app, &$body) {
                $body .= $_REQUEST['test-events-content']['content.admin'];
            }, EventManager::LOW);

            $this->_cms->on('cms.content', function (Cms $app, &$body) {
                $body .= $_REQUEST['test-events-content']['content'];
            }, EventManager::HIGH);

            $this->_cms['events']->filterContent();
        }
    }

    public function onBeforeCompileHead()
    {
        if (!$this->_request('jbzoo-phpunit')) {
            return;
        }

        /* Events:header ***********************************************************************************************/
        if ($this->_request('test-events-header')) {
            $this->_cms->on('cms.header.site', function () {
                echo $_REQUEST['test-events-header']['header.site'];
            });

            $this->_cms->on('cms.header.admin', function () {
                echo $_REQUEST['test-events-header']['header.admin'];
            }, EventManager::LOW);

            $this->_cms->on('cms.header', function () {
                echo $_REQUEST['test-events-header']['header'];
            }, EventManager::HIGH);

            $this->_cms->trigger(AbstractEvents::EVENT_HEADER);
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
            $this->_cms->on('cms.init.site', function () {
                echo $_REQUEST['test-events-init']['init.site'];
            });

            $this->_cms->on('cms.init.admin', function () {
                echo $_REQUEST['test-events-init']['init.admin'];
            }, EventManager::LOW);

            $this->_cms->on('cms.init', function () {
                echo $_REQUEST['test-events-init']['init'];
            }, EventManager::HIGH);

            // Execute Trigger
            $this->_cms->trigger(AbstractEvents::EVENT_INIT);
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
