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

namespace JBZoo\CrossCMS;

use JBZoo\CrossCMS\Entity\User;
use JBZoo\Utils\Vars;

/**
 * Class AbstractUser
 * @package JBZoo\CrossCMS
 */
abstract class AbstractUser
{
    /**
     * @var array
     */
    protected $_users = [];

    /**
     * @param $id
     * @return User|null
     */
    protected function _getEntity($id)
    {
        return Vars::get($this->_users[$id]);
    }

    /**
     * @return User
     */
    abstract public function getCurrent();

    /**
     * @param int $userId
     * @return User
     */
    abstract public function getById($userId);

    /**
     * @param string $email
     * @return User
     */
    abstract public function getByEmail($email);

    /**
     * @param string $login
     * @return User
     */
    abstract public function getByLogin($login);
}
