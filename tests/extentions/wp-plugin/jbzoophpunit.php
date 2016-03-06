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

    $cms = Cms::getInstance();

    /* Assets *********************************************************************************************************/
    add_action('wp', function () use ($cms) {

        if (isset($_REQUEST['test-assets-jsfile'])) {
            $cms['assets']->jsFile('http://site.com/' . $_REQUEST['test-assets-jsfile'] . 'js');
        }

        if (isset($_REQUEST['test-assets-jscode'])) {
            $cms['assets']->jsCode($_REQUEST['test-assets-jscode']);
        }

        if (isset($_REQUEST['test-assets-cssfile'])) {
            $cms['assets']->cssFile('http://site.com/' . $_REQUEST['test-assets-cssfile'] . 'css');
        }

        if (isset($_REQUEST['test-assets-csscode'])) {
            $cms['assets']->cssCode($_REQUEST['test-assets-csscode']);
        }
    });

    /* Response *******************************************************************************************************/
    add_action('wp', function () use ($cms) {

        if (isset($_REQUEST['test-response-set404'])) {
            $cms['response']->set404();
        }

        if (isset($_REQUEST['test-response-set500'])) {
            $cms['response']->set500($_REQUEST['test-response-set500']);
        }

        if (isset($_REQUEST['test-response-redirect'])) {
            $cms['response']->redirect($_REQUEST['test-response-redirect']);
        }

        if (isset($_REQUEST['test-response-json'])) {
            $cms['response']->json((array)$_REQUEST['test-response-json'], true);
        }

        if (isset($_REQUEST['test-response-text'])) {
            $cms['response']->text();
        }

        if (isset($_REQUEST['test-response-title'])) {
            $cms['response']->setTitle($_REQUEST['test-response-title']);
        }

        if (isset($_REQUEST['test-response-noindex'])) {
            $cms['response']->noindex();
        }

        if (isset($_REQUEST['test-response-description'])) {
            $cms['response']->setDesc($_REQUEST['test-response-description']);
        }

        if (isset($_REQUEST['test-response-keywords'])) {
            $cms['response']->setKeywords($_REQUEST['test-response-keywords']);
        }

        if (isset($_REQUEST['test-response-nocache'])) {
            $cms['response']->noCache();
        }

        if (isset($_REQUEST['test-response-raw'])) {
            $cms['response']->raw();
        }

        if (isset($_REQUEST['test-response-component'])) {
            $cms['response']->component();
        }

        if (isset($_REQUEST['test-response-addmeta'])) {

            $_REQUEST['test-response-addmeta']['meta'] = str_replace(
                array('\\"', "\\'"),
                array('"', "'"),
                $_REQUEST['test-response-addmeta']['meta']
            );

            $cms['response']->addMeta(
                $_REQUEST['test-response-addmeta']['meta'],
                Vars::get($_REQUEST['test-response-addmeta']['value'])
            );
        }
    });

    /* Events::init ****************************************************************************************************/
    if (isset($_REQUEST['test-events-init'])) {

        $cms->on('cms.init.site', function () {
            echo $_REQUEST['test-events-init']['init.site'];
        });

        $cms->on('cms.init.admin', function () {
            echo $_REQUEST['test-events-init']['init.admin'];
        }, EventManager::LOW);

        $cms->on('cms.init', function () {
            echo $_REQUEST['test-events-init']['init'];
        }, EventManager::HIGH);

        // Examples of trigger for Wordpress
        add_action('wp', function () use ($cms) {
            $cms->trigger(AbstractEvents::EVENT_INIT);
        });
    }

    /* Events::header **************************************************************************************************/
    if (isset($_REQUEST['test-events-header'])) {

        $cms->on('cms.header.site', function () {
            echo $_REQUEST['test-events-header']['header.site'];
        });

        $cms->on('cms.header.admin', function () {
            echo $_REQUEST['test-events-header']['header.admin'];
        }, EventManager::LOW);

        $cms->on('cms.header', function () {
            echo $_REQUEST['test-events-header']['header'];
        }, EventManager::HIGH);

        // Examples of trigger for Wordpress
        add_action('wp_head', function () use ($cms) {
            $cms->trigger(AbstractEvents::EVENT_HEADER);
        });
    }

    /* Events::content *************************************************************************************************/
    if (isset($_REQUEST['test-events-content'])) {
        $cms->on('cms.content.site', function (Cms $app, &$body) {
            $body .= $_REQUEST['test-events-content']['content.site'];
        });

        $cms->on('cms.content.admin', function (Cms $app, &$body) {
            $body .= $_REQUEST['test-events-content']['content.admin'];
        }, EventManager::LOW);

        $cms->on('cms.content', function (Cms $app, &$body) {
            $body .= $_REQUEST['test-events-content']['content'];
        }, EventManager::HIGH);

        add_filter('the_content', function ($content) use ($cms) {
            $cms['events']->filterContent($content);
            return $content;
        });
    }

    /* Libs ***********************************************************************************************************/
    if (isset($_REQUEST['test-libs-jquery'])) {
        $cms['libs']->jQuery();
    }

    if (isset($_REQUEST['test-libs-jqueryui'])) {
        $cms['libs']->jQueryUI();
    }

    if (isset($_REQUEST['test-libs-autocomplete'])) {
        $cms['libs']->jQueryAutocomplete();
    }

    if (isset($_REQUEST['test-libs-datepicker'])) {
        $cms['libs']->jQueryDatePicker();
    }

    if (isset($_REQUEST['test-libs-colorpicker'])) {
        $cms['libs']->colorPicker();
    }
}
