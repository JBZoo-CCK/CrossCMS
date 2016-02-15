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

namespace JBZoo\CrossCMS\Wordpress;

use JBZoo\CrossCMS\AbstractResponse;
use JBZoo\CrossCMS\Cms;
use JBZoo\Utils\Vars;

/**
 * Class Request
 * @package JBZoo\CrossCMS
 */
class Response extends AbstractResponse
{
    /**
     * @var \WP_Query
     */
    private $_wp_query = null;

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function __construct()
    {
        $this->_wp_query = Vars::get($GLOBALS['wp_query']);
    }

    /**
     * {@inheritdoc}
     */
    public function set404($message = 'Not Found')
    {
        $this->_wp_query->set_404();
        status_header(404);
        nocache_headers();
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public function set500($message = 'Internal Server Error')
    {
        $trace = '';
        if (Cms::_('config')->isDebug()) {
            ob_start();
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            $trace = '<pre>' . ob_get_contents() . '</pre>';
            ob_end_clean();
        }

        status_header(500);
        nocache_headers();
        $this->setHeader('Content-Type', 'text/html; charset=utf-8');

        echo implode(PHP_EOL, array(
            '<!DOCTYPE html>',
            '<html xmlns="http://www.w3.org/1999/xhtml"' . (is_rtl() ? ' dir="rtl"' : '') . '>',
            '<head>',
            '    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />',
            '    <title>' . esc_attr(translate('500 - Internal Server Error')) . '</title>',
            '</head>',
            '<body>',
            '<h1>' . esc_html(translate($message)) . '</h1>',
            $trace,
            '</body>',
            '</html>',
        ));
        die();
    }

    /**
     * {@inheritdoc}
     */
    public function redirect($url, $status = 303)
    {
        wp_redirect($url, (int)$status);
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public function json(array $data = array(), $result = true)
    {
        $data['message'] = Vars::get($data['message']);
        $data['result']  = (int)$result;

        $this->noCache();
        $this->setHeader('Content-Type', 'application/json; charset=utf-8');

        echo json_encode((array)$data);
        die();
    }

    /**
     * {@inheritdoc}
     * TODO Create RAW output for Wordpress!
     */
    public function raw()
    {
        Cms::_('request')->set('tmpl', 'raw'); // logical hack
    }

    /**
     * {@inheritdoc}
     * TODO Create Component output Wordpress!
     */
    public function component()
    {
        Cms::_('request')->set('tmpl', 'component'); // logical hack
    }

    /**
     * {@inheritdoc}
     */
    public function noindex()
    {
        $this->addMeta('robots', 'noindex, nofollow');
        $this->setHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    /**
     * {@inheritdoc}
     */
    public function text()
    {
        $this->setHeader('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * {@inheritdoc}
     */
    public function setHeader($name, $value)
    {
        if (!headers_sent()) {
            header($name . ': ' . $value, true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function noCache()
    {
        nocache_headers();
        $this->_noCache();
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        add_filter('pre_get_document_title', function () use ($title) {
            return $title;
        }, 9999);
    }

    /**
     * {@inheritdoc}
     */
    public function addMeta($meta, $value = null)
    {
        add_action('wp_head', function () use ($meta, $value) {
            if (null === $value) {
                echo $meta . PHP_EOL;
            } else {
                echo '<meta name="' . esc_attr($meta) . '" content="' . esc_attr($value) . '" />' . PHP_EOL;
            }
        }, 9999);
    }

    /**
     * {@inheritdoc}
     */
    public function setDesc($description)
    {
        $this->addMeta('description', $description);
    }

    /**
     * {@inheritdoc}
     */
    public function setKeywords($keywords)
    {
        $this->addMeta('keywords', $keywords);
    }
}
