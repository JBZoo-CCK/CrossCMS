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

use JBZoo\CrossCMS\AbstractUser;
use JBZoo\CrossCMS\Cms;
use JBZoo\CrossCMS\Entity\User as UserEntity;
use JBZoo\Data\Data;
use JBZoo\SqlBuilder\Query\Select;

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
        $user = \JFactory::getUser(null);
        return $this->_convertToEntity($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getById($userId)
    {
        $user = \JFactory::getUser((int)$userId);

        if (!$user || (int)$user->id === 0) {
            return null;
        }

        return $this->_convertToEntity($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getByLogin($login)
    {
        $id = $this->_findUserIdBy('username', $login);
        return $id ? $this->getById($id) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getByEmail($email)
    {
        $id = $this->_findUserIdBy('email', $email);
        return $id ? $this->getById($id) : null;
    }

    /**
     * @param \JUser $user
     * @return UserEntity
     */
    protected function _convertToEntity(\JUser $user)
    {
        $id = (int)$user->id;

        if ($entity = $this->_getEntity($id)) {
            return $entity;
        }

        $isAdmin = $user->authorise('core.login.admin', 'root.1') || $user->authorise('core.admin', 'root.1');

        $data = new Data([
            'id'       => $id,
            'login'    => $user->username,
            'name'     => $user->name,
            'email'    => $user->email,
            'is_admin' => $isAdmin,
        ]);

        $this->_users[$id] = new UserEntity($data);

        return $this->_users[$id];
    }

    /**
     * @param string $key
     * @param string $value
     * @return int|null
     */
    protected function _findUserIdBy($key, $value)
    {
        $db = Cms::_('db');

        $select = (new Select('#__users', 'tUser'))
            ->select('tUser.id')
            ->where(['tUser.' . $key, '= ?s'], $value)
            ->limit(1);

        $result = $db->fetchRow($select);

        return $result ? $result['id'] : null;
    }
}
