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

use JBZoo\CrossCMS\AbstractUser;
use JBZoo\CrossCMS\Entity\User as UserEntity;
use JBZoo\Data\Data;
use JBZoo\Utils\Vars;

/**
 * Class User
 * @package JBZoo\CrossCMS
 */
class User extends AbstractUser
{
    /**
     * {@inheritdoc}
     */
    public function getCurrent()
    {
        $user = wp_get_current_user();
        return $this->_convertToEntity($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getById($userId)
    {
        if ($user = get_user_by('ID', $userId)) {
            return $this->_convertToEntity($user);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getByLogin($login)
    {
        if ($user = get_user_by('login', $login)) {
            return $this->_convertToEntity($user);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getByEmail($email)
    {
        if ($user = get_user_by('email', $email)) {
            return $this->_convertToEntity($user);
        }

        return null;
    }

    /**
     * @param \WP_User $user
     * @return UserEntity|null
     */
    protected function _convertToEntity(\WP_User $user)
    {
        $id = (int)$user->ID;
        if ($entity = $this->_getEntity($id)) {
            return $entity;
        }

        $caps    = $user->get_role_caps();
        $isAdmin = (bool)Vars::get($caps['administrator'], false);

        $data = new Data([
            'id'       => $id,
            'login'    => $user->get('user_login'),
            'name'     => $user->get('display_name'),
            'email'    => $user->get('user_email'),
            'is_admin' => $isAdmin,
        ]);

        $this->_users[$id] = new UserEntity($data);

        return $this->_users[$id];
    }
}
