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

use JBZoo\CrossCMS\AbstractRequest;

/**
 * Class Request
 * @package JBZoo\CrossCMS
 */
class Request extends AbstractRequest
{
    /**
     * @var \JInput
     */
    private $_input = null;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->_input = \JFactory::getApplication()->input;
    }

    /**
     * {@inheritdoc}
     */
    protected function _get($name, $default = null)
    {
        return $this->_input->get($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    protected function _set($name, $value)
    {
        $this->_input->set($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function checkToken($name = 'crosscms')
    {
        $method = strtolower($this->getMethod());
        return \JSession::checkToken($method);
    }
}
