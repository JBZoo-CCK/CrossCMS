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

namespace JBZoo\CrossCMS\Joomla;

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
     * @var \JDocumentHTML
     */
    private $_doc = null;

    /**
     * @var \JApplicationCms
     */
    private $_app = null;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->_app = \JFactory::getApplication();
        $this->_doc = \JFactory::getDocument();
    }

    /**
     * {@inheritdoc}
     */
    public function set404($message = 'Not Found')
    {
        if (class_exists('\JError')) {
            \JError::raiseError(404, $message); // Change to new API
        } else {
            throw new \Exception($message, 404);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function set500($message = 'Internal Server Error')
    {
        if (class_exists('\JError')) {
            \JError::raiseError(500, $message); // Change to new API
        } else {
            throw new \Exception($message, 500);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function json(array $data = array(), $result = true)
    {
        $data['message'] = Vars::get($data['message']);
        $data['result']  = (int)$result;

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
        Cms::_('request')->set('tmpl', 'raw');
    }

    /**
     * {@inheritdoc}
     */
    public function component()
    {
        Cms::_('request')->set('tmpl', 'component');
    }

    /**
     * {@inheritdoc}
     */
    public function noindex()
    {
        $this->_doc->setMetadata('robots', 'noindex, nofollow');
        $this->setHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    /**
     * {@inheritdoc}
     */
    public function redirect($url, $status = 303)
    {
        \JFactory::getApplication()->redirect($url, $status);
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

    /**
     * {@inheritdoc}
     */
    public function addMeta($meta)
    {
        $this->_doc->addCustomTag($meta);
    }

    /**
     * {@inheritdoc}
     */
    public function setDesc($description)
    {
        $this->_doc->setDescription($description);
        $this->_doc->setMetadata('description', $description);
    }

    /**
     * {@inheritdoc}
     */
    public function setKeywords($keywords)
    {
        $this->_doc->setMetadata('keywords', $keywords);
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->_doc->setTitle($title);
    }
}
