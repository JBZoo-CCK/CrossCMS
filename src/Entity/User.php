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

namespace JBZoo\CrossCMS\Entity;

use JBZoo\Data\Data;
use JBZoo\Utils\Arr;
use JBZoo\Utils\Url;

/**
 * Class AbstractAssets
 * @package JBZoo\CrossCMS
 */
class User
{
    /**
     * @var int
     */
    protected $_id;

    /**
     * @var string
     */
    protected $_name;

    /**
     * @var string
     */
    protected $_login;

    /**
     * @var string
     */
    protected $_email;

    /**
     * @var string
     */
    protected $_isAdmin;

    /**
     * @var string
     */
    protected $_isActive;

    /**
     * @param Data $data
     */
    public function __construct(Data $data)
    {
        $this->_id      = $data->get('id', 0, 'int');
        $this->_login   = $data->get('login', '', 'low');
        $this->_email   = $data->get('email', '', 'email, low');
        $this->_name    = $data->get('name', '', 'trim');
        $this->_isAdmin = $data->get('is_admin', false, 'bool');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email ?: null;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->isGuest() ? 'Guest' : $this->_name;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->_login ?: null;
    }

    /**
     * @return string
     */
    public function isAdmin()
    {
        return $this->_isAdmin;
    }

    /**
     * @return string
     */
    public function isGuest()
    {
        return 0 === $this->_id;
    }

    /**
     * Get user avatar by email
     *
     * @param int    $avatarSize
     * @param string $defaultPic
     * @return string
     */
    public function getAvatar($avatarSize = 64, $defaultPic = 'identicon')
    {
        $md5        = md5(trim($this->_email));
        $avatarSize = (int)$avatarSize;
        $defaultPic = trim($defaultPic);

        $validList = array('404', 'mm', 'identicon', 'monsterid', 'wavatar', 'retro', 'blank');

        if (strpos($defaultPic, 'http') === 0) {
            $default = urlencode($defaultPic);
        } elseif (Arr::in((string)$defaultPic, $validList)) {
            $default = $defaultPic;
        } else {
            $default = 'identicon';
        }

        if (Url::isHttps()) {
            $avatarUrl = 'https://secure.gravatar.com/avatar/' . $md5 . '.jpg?s=' . $avatarSize . '&d=' . $default;
        } else {
            $avatarUrl = 'http://www.gravatar.com/avatar/' . $md5 . '.jpg?s=' . $avatarSize . '&d=' . $default;
        }

        return $avatarUrl;
    }
}
