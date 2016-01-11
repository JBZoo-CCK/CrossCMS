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


use JBZoo\CrossCMS\Cms;

if (isset($_REQUEST['jbzoo-phpunit'])) {

    $assets = Cms::_('assets');

    if (isset($_REQUEST['test-assets-jsfile'])) {
        $assets->jsFile('http://site.com/' . $_REQUEST['test-assets-jsfile'] . 'js');
    }

    if (isset($_REQUEST['test-assets-jscode'])) {
        $assets->jsCode($_REQUEST['test-assets-jscode']);
    }


    if (isset($_REQUEST['test-assets-cssfile'])) {
        $assets->cssFile('http://site.com/' . $_REQUEST['test-assets-cssfile'] . 'css');
    }

    if (isset($_REQUEST['test-assets-csscode'])) {
        $assets->cssCode($_REQUEST['test-assets-csscode']);
    }

}
