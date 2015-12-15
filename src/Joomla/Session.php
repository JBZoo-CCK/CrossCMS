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

use JBZoo\CrossCMS\AbstractSession;

/**
 * Class Session
 * @package JBZoo\CrossCMS
 */
class Session extends AbstractSession
{
    /**
     * @var \JSession
     */
    private $_session = null;

    /**
     * @var string
     */
    private $_namespace = 'jbzoo_joomla';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->_session = \JFactory::getSession();
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $group = self::GROUP_DFAULT)
    {
        $data = $this->_session->get($group, array(), $this->_namespace);

        $data[$key] = $value;

        $this->_session->set($group, $data, $this->_namespace);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null, $group = self::GROUP_DFAULT)
    {
        $data = $this->getGroup($group, $default);

        if (isset($data[$key])) {
            return $data[$key];
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroup($group = self::GROUP_DFAULT, $default = array())
    {
        $data = $this->_session->get($group, $default, $this->_namespace);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function setGroup($group = self::GROUP_DFAULT, array $data = array(), $isFullReplace = true)
    {
        if ($isFullReplace) {
            $this->clearGroup($group);
        }

        foreach ($data as $key => $value) {
            $this->set($key, $value, $group);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clearGroup($group = self::GROUP_DFAULT)
    {
        $this->_session->set($group, null, $this->_namespace);
    }

    /**
     * {@inheritdoc}
     */
    public function clear($key, $group = self::GROUP_DFAULT)
    {
        $this->set($key, null, $group);
    }

    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        return \JFactory::getSession()->getToken();
    }

}
