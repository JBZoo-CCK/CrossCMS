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

namespace JBZoo\CrossCMS\Wordpress;

use JBZoo\CrossCMS\AbstractEvents;
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
    private $_wp_query;

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function __construct(Cms $cms)
    {
        parent::__construct($cms);
        $this->_wp_query = Vars::get($GLOBALS['wp_query']);
    }

    /**
     * {@inheritdoc}
     */
    public function set404($message = 'Not Found')
    {
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN);
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN . '.404', [&$message]);

        $this->_wp_query->set_404();
        status_header(404);
        $this->noCache();

        \_default_wp_die_handler($message, $message, array(
            'response'  => 404,
            'back_link' => true,
        ));
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @codeCoverageIgnore
     */
    public function set500($message = 'Internal Server Error')
    {
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN);
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN . '.500', [&$message]);

        $trace = '';
        if ($this->_cms['config']->isDebug()) {
            ob_start();
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            $trace = '<pre>' . ob_get_contents() . '</pre>';
            ob_end_clean();
        }

        status_header(500);
        $this->noCache();
        $this->setHeader('Content-Type', 'text/html; charset=utf-8');

        \_default_wp_die_handler($message . '<hr>' . $trace, '', array(
            'response'  => 500,
            'back_link' => true,
        ));
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function redirect($url, $status = 303)
    {
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN);
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN . '.redirect', [&$url, &$status]);

        wp_redirect($url, (int)$status);
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @codeCoverageIgnore
     */
    public function json(array $data = array(), $result = true)
    {
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN);
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN . '.json', [&$data, &$result]);

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
        $this->_cms['request']->set('tmpl', 'raw'); // logical hack
    }

    /**
     * {@inheritdoc}
     * TODO Create Component output Wordpress!
     */
    public function component()
    {
        $this->_cms['request']->set('tmpl', 'component'); // logical hack
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
}
