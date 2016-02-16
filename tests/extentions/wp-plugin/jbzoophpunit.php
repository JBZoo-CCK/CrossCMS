<?php
/**
 * @package JBZoo_PHPUnit
 * @version 1.0
 */
/*
Plugin Name: JBZoo PHPUnit
Description: JBZoo PHPUnit Plugin for unit-testing
Author: Denis Smetannikov <denis@jbzoo.com>
Version: 1.0
Author URI: http://jbzoo.com
*/


use JBZoo\CrossCMS\AbstractEvent;
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

    /* Event::init ****************************************************************************************************/
    if (isset($_REQUEST['test-event-init'])) {

        Cms::_('event')->on('cms.init.site', function () {
            echo $_REQUEST['test-event-init']['init.site'];
        });

        Cms::_('event')->on('cms.init.admin', function () {
            echo $_REQUEST['test-event-init']['init.admin'];
        }, EventManager::LOW);

        Cms::_('event')->on('cms.init', function () {
            echo $_REQUEST['test-event-init']['init'];
        }, EventManager::HIGH);

        // Examples of trigger for Wordpress
        add_action('wp', function () {
            Cms::_('event')->trigger(AbstractEvent::EVENT_INIT);
        });
    }

    /* Event::header **************************************************************************************************/
    if (isset($_REQUEST['test-event-header'])) {

        Cms::_('event')->on('cms.header.site', function () {
            echo $_REQUEST['test-event-header']['header.site'];
        });

        Cms::_('event')->on('cms.header.admin', function () {
            echo $_REQUEST['test-event-header']['header.admin'];
        }, EventManager::LOW);

        Cms::_('event')->on('cms.header', function () {
            echo $_REQUEST['test-event-header']['header'];
        }, EventManager::HIGH);

        // Examples of trigger for Wordpress
        add_action('wp_head', function () {
            Cms::_('event')->trigger(AbstractEvent::EVENT_HEADER);
        });
    }

    /* Event::content *************************************************************************************************/
    if (isset($_REQUEST['test-event-content'])) {
        Cms::_('event')->on('cms.content.site', function (&$body) {
            $body .= $_REQUEST['test-event-content']['content.site'];
        });

        Cms::_('event')->on('cms.content.admin', function (&$body) {
            $body .= $_REQUEST['test-event-content']['content.admin'];
        }, EventManager::LOW);

        Cms::_('event')->on('cms.content', function (&$body) {
            $body .= $_REQUEST['test-event-content']['content'];
        }, EventManager::HIGH);

        add_filter('the_content', function ($content) {
            Cms::_('event')->filterContent($content);
            return $content;
        });
    }
}
