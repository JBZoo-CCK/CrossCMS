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

namespace JBZoo\CrossCMS\Joomla;

use JBZoo\CrossCMS\AbstractEvents;
use JBZoo\CrossCMS\AbstractResponse;
use JBZoo\CrossCMS\Cms;
use JBZoo\Utils\Ob;

/**
 * Class Request
 * @package JBZoo\CrossCMS
 */
class Response extends AbstractResponse
{
    /**
     * @var \JApplicationCms
     */
    private $_app = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(Cms $cms)
    {
        parent::__construct($cms);
        $this->_app = \JFactory::getApplication();
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function set404($message = 'Not Found')
    {
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN);
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN . '.404', [&$message]);

        Ob::clean();
        $this->noCache();

        throw new \Exception($message, 404);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function set500($message = 'Internal Server Error')
    {
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN);
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN . '.500', [&$message]);

        Ob::clean();
        $this->noCache();

        throw new \Exception($message, 500);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function redirect($url, $status = 303)
    {
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN);
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN . '.redirect', [&$url, &$status]);

        \JFactory::getApplication()->redirect($url, $status);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function json(array $data = array(), $result = true)
    {
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN);
        $this->_cms->trigger(AbstractEvents::EVENT_SHUTDOWN . '.json', [&$data, &$result]);

        Ob::clean();
        $this->noCache();
        $this->setHeader('Content-Type', 'application/json; charset=utf-8');
        $this->_app->sendHeaders();

        echo json_encode((array)$data);
        jexit();
    }

    /**
     * {@inheritdoc}
     */
    public function raw()
    {
        $this->_cms['request']->set('tmpl', 'raw');
    }

    /**
     * {@inheritdoc}
     */
    public function component()
    {
        $this->_cms['request']->set('tmpl', 'component');
    }

    /**
     * {@inheritdoc}
     */
    public function setHeader($name, $value)
    {
        $this->_app->setHeader($name, $value, true);
    }

    /**
     * {@inheritdoc}
     */
    public function noCache()
    {
        $this->_app->allowCache(false);
        $this->_noCache();
    }
}
