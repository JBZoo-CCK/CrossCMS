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

namespace JBZoo\PHPUnit;

use JBZoo\CrossCMS\Cms;

/**
 * Class UserTest
 * @package JBZoo\PHPUnit
 */
class UserTest extends PHPUnit
{
    /**
     * @return \JBZoo\CrossCMS\AbstractUser
     */
    protected function _getUser()
    {
        $cms = Cms::getInstance();
        return $cms['user'];
    }

    public function testCurrentGuest()
    {
        $helper = $this->_getUser();
        $user   = $helper->getCurrent();

        isSame(true, $user->isGuest());
        isSame(false, $user->isAdmin());
        isSame(null, $user->getEmail());
        isSame(null, $user->getLogin());
        isSame('Guest', $user->getName());
        isSame(0, $user->getId());
    }

    public function testGetAdminByID()
    {
        if (Cms::_('type') === Cms::TYPE_WORDPRESS) {

            /** @var \JBZoo\CrossCMS\Wordpress\User $helper */
            $helper = $this->_getUser();

            $user = $helper->getById(1);
            isSame(false, $user->isGuest());
            isSame(true, $user->isAdmin());
            isSame('admin@example.com', $user->getEmail());
            isSame('admin', $user->getLogin());
            isSame('admin', $user->getName());
            isSame(1, $user->getId());

            $user = $helper->getByLogin('admin');
            isSame(false, $user->isGuest());
            isSame(true, $user->isAdmin());
            isSame('admin@example.com', $user->getEmail());
            isSame('admin', $user->getLogin());
            isSame('admin', $user->getName());
            isSame(1, $user->getId());

            $user = $helper->getByEmail('admin@example.com');
            isSame(false, $user->isGuest());
            isSame(true, $user->isAdmin());
            isSame('admin@example.com', $user->getEmail());
            isSame('admin', $user->getLogin());
            isSame('admin', $user->getName());
            isSame(1, $user->getId());

        } elseif (Cms::_('type') === Cms::TYPE_JOOMLA) {

            /** @var \JBZoo\CrossCMS\Joomla\User $helper */
            $helper = $this->_getUser();

            $user = $helper->getById(951);
            isSame(false, $user->isGuest());
            isSame(true, $user->isAdmin());
            isSame('admin@example.com', $user->getEmail());
            isSame('admin', $user->getLogin());
            isSame('Super User', $user->getName());
            isSame(951, $user->getId());

            $user = $helper->getByLogin('admin');
            isSame(false, $user->isGuest());
            isSame(true, $user->isAdmin());
            isSame('admin@example.com', $user->getEmail());
            isSame('admin', $user->getLogin());
            isSame('Super User', $user->getName());
            isSame(951, $user->getId());

            $user = $helper->getByEmail('admin@example.com');
            isSame(false, $user->isGuest());
            isSame(true, $user->isAdmin());
            isSame('admin@example.com', $user->getEmail());
            isSame('admin', $user->getLogin());
            isSame('Super User', $user->getName());
            isSame(951, $user->getId());
        }
    }

    public function testUndefinedUser()
    {
        $helper = $this->_getUser();

        isSame(null, $helper->getById(mt_rand(100000, 999999)));
        isSame(null, $helper->getByLogin(uniqid()));
        isSame(null, $helper->getByEmail(uniqid()));
    }

    public function testGravatar()
    {
        $helper = $this->_getUser();

        $user = $helper->getCurrent();
        isSame(
            'http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e.jpg?s=64&d=identicon',
            $user->getAvatar()
        );

        isSame(
            'http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e.jpg?s=128&d=identicon',
            $user->getAvatar(128)
        );

        isSame(
            'http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e.jpg?s=128&d=identicon',
            $user->getAvatar(128, 'qwerty')
        );

        isSame(
            'http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e.jpg?s=128&d=http%3A%2F%2Fexample.com%2Fimages%2Favatar.jpg',
            $user->getAvatar(128, 'http://example.com/images/avatar.jpg')
        );

        $_SERVER['HTTPS'] = 'on';
        isSame(
            'https://secure.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e.jpg?s=128&d=mm',
            $user->getAvatar(128, 'mm')
        );
    }
}
