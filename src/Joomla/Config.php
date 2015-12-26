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

use JBZoo\CrossCMS\AbstractConfig;

/**
 * Class Session
 * @package JBZoo\CrossCMS
 */
class Config extends AbstractConfig
{
    /**
     * @var \Joomla\Registry\Registry
     */
    protected $_config = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_config = \JFactory::getConfig();
    }

    /**
     * {@inheritdoc}
     */
    public function sitename()
    {
        return $this->_config->get('sitename');
    }

    /**
     * {@inheritdoc}
     */
    public function sitedesc()
    {
        return $this->_config->get('MetaDesc', '');
    }

    /**
     * {@inheritdoc}
     */
    public function email()
    {
        return $this->_config->get('mailfrom');
    }

    /**
     * {@inheritdoc}
     */
    public function dbHost()
    {
        return $this->_config->get('host');
    }

    /**
     * {@inheritdoc}
     */
    public function dbUser()
    {
        return $this->_config->get('user');
    }

    /**
     * {@inheritdoc}
     */
    public function dbPass()
    {
        return $this->_config->get('password', '');
    }

    /**
     * {@inheritdoc}
     */
    public function dbName()
    {
        return $this->_config->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function dbPrefix()
    {
        return $this->_config->get('dbprefix');
    }

    /**
     * {@inheritdoc}
     */
    public function dbType()
    {
        return $this->_config->get('dbtype');
    }

    /**
     * {@inheritdoc}
     */
    public function isDebug()
    {
        $debug = (int)$this->_config->get('debug');

        return (bool)$debug;
    }

    /**
     * {@inheritdoc}
     */
    public function timezone()
    {
        return $this->_config->get('offset');
    }
}
