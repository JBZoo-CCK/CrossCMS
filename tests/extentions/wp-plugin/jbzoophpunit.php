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
/*
Plugin Name: JBZoo PHPUnit
Description: JBZoo PHPUnit Plugin for unit-testing
Author: Denis Smetannikov <denis@jbzoo.com>
Version: 1.0
Author URI: http://jbzoo.com
*/


use JBZoo\CrossCMS\AbstractEvents;
use JBZoo\CrossCMS\Cms;
use JBZoo\Event\EventManager;
use JBZoo\Utils\Vars;

if (!class_exists('\JBZoo\CrossCMS\Cms')) {
    if ($autoloadPath = realpath('../../vendor/autoload.php')) {
        require_once $autoloadPath;
    }
}

if (isset($_REQUEST['jbzoo-phpunit']) && class_exists('\JBZoo\CrossCMS\Cms')) {

    /* Assets *********************************************************************************************************/
    add_action('wp', function () {
        if (isset($_REQUEST['test-assets-jsfile'])) {
            Cms::_('assets')->jsFile('http://site.com/' . $_REQUEST['test-assets-jsfile'] . 'js');
        }

        if (isset($_REQUEST['test-assets-jscode'])) {
            Cms::_('assets')->jsCode($_REQUEST['test-assets-jscode']);
        }

        if (isset($_REQUEST['test-assets-cssfile'])) {
            Cms::_('assets')->cssFile('http://site.com/' . $_REQUEST['test-assets-cssfile'] . 'css');
        }

        if (isset($_REQUEST['test-assets-csscode'])) {
            Cms::_('assets')->cssCode($_REQUEST['test-assets-csscode']);
        }
    });

    /* Response *******************************************************************************************************/
    add_action('wp', function () {
        if (isset($_REQUEST['test-response-set404'])) {
            Cms::_('response')->set404();
        }

        if (isset($_REQUEST['test-response-set500'])) {
            Cms::_('response')->set500($_REQUEST['test-response-set500']);
        }

        if (isset($_REQUEST['test-response-redirect'])) {
            Cms::_('response')->redirect($_REQUEST['test-response-redirect']);
        }

        if (isset($_REQUEST['test-response-json'])) {
            Cms::_('response')->json((array)$_REQUEST['test-response-json'], true);
        }

        if (isset($_REQUEST['test-response-text'])) {
            Cms::_('response')->text();
        }

        if (isset($_REQUEST['test-response-title'])) {
            Cms::_('response')->setTitle($_REQUEST['test-response-title']);
        }

        if (isset($_REQUEST['test-response-noindex'])) {
            Cms::_('response')->noindex();
        }

        if (isset($_REQUEST['test-response-description'])) {
            Cms::_('response')->setDesc($_REQUEST['test-response-description']);
        }

        if (isset($_REQUEST['test-response-keywords'])) {
            Cms::_('response')->setKeywords($_REQUEST['test-response-keywords']);
        }

        if (isset($_REQUEST['test-response-nocache'])) {
            Cms::_('response')->noCache();
        }

        if (isset($_REQUEST['test-response-raw'])) {
            Cms::_('response')->raw();
        }

        if (isset($_REQUEST['test-response-component'])) {
            Cms::_('response')->component();
        }

        if (isset($_REQUEST['test-response-addmeta'])) {

            $_REQUEST['test-response-addmeta']['meta'] = str_replace(
                array('\\"', "\\'"),
                array('"', "'"),
                $_REQUEST['test-response-addmeta']['meta']
            );

            Cms::_('response')->addMeta(
                $_REQUEST['test-response-addmeta']['meta'],
                Vars::get($_REQUEST['test-response-addmeta']['value'])
            );
        }
    });

    /* Events::init ****************************************************************************************************/
    if (isset($_REQUEST['test-events-init'])) {

        Cms::_('events')->on('cms.init.site', function () {
            echo $_REQUEST['test-events-init']['init.site'];
        });

        Cms::_('events')->on('cms.init.admin', function () {
            echo $_REQUEST['test-events-init']['init.admin'];
        }, EventManager::LOW);

        Cms::_('events')->on('cms.init', function () {
            echo $_REQUEST['test-events-init']['init'];
        }, EventManager::HIGH);

        // Examples of trigger for Wordpress
        add_action('wp', function () {
            Cms::_('events')->trigger(AbstractEvents::EVENT_INIT);
        });
    }

    /* Events::header **************************************************************************************************/
    if (isset($_REQUEST['test-events-header'])) {

        Cms::_('events')->on('cms.header.site', function () {
            echo $_REQUEST['test-events-header']['header.site'];
        });

        Cms::_('events')->on('cms.header.admin', function () {
            echo $_REQUEST['test-events-header']['header.admin'];
        }, EventManager::LOW);

        Cms::_('events')->on('cms.header', function () {
            echo $_REQUEST['test-events-header']['header'];
        }, EventManager::HIGH);

        // Examples of trigger for Wordpress
        add_action('wp_head', function () {
            Cms::_('events')->trigger(AbstractEvents::EVENT_HEADER);
        });
    }

    /* Events::content *************************************************************************************************/
    if (isset($_REQUEST['test-events-content'])) {
        Cms::_('events')->on('cms.content.site', function (&$body) {
            $body .= $_REQUEST['test-events-content']['content.site'];
        });

        Cms::_('events')->on('cms.content.admin', function (&$body) {
            $body .= $_REQUEST['test-events-content']['content.admin'];
        }, EventManager::LOW);

        Cms::_('events')->on('cms.content', function (&$body) {
            $body .= $_REQUEST['test-events-content']['content'];
        }, EventManager::HIGH);

        add_filter('the_content', function ($content) {
            Cms::_('events')->filterContent($content);
            return $content;
        });
    }

    /* Libs ***********************************************************************************************************/
    if (isset($_REQUEST['test-libs-jquery'])) {
        Cms::_('libs')->jQuery();
    }

    if (isset($_REQUEST['test-libs-jqueryui'])) {
        Cms::_('libs')->jQueryUI();
    }

    if (isset($_REQUEST['test-libs-autocomplete'])) {
        Cms::_('libs')->jQueryAutocomplete();
    }

    if (isset($_REQUEST['test-libs-datepicker'])) {
        Cms::_('libs')->jQueryDatePicker();
    }

    if (isset($_REQUEST['test-libs-colorpicker'])) {
        Cms::_('libs')->colorPicker();
    }
}
