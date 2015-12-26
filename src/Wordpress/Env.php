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

namespace JBZoo\CrossCMS\Wordpress;

use JBZoo\CrossCMS\AbstractEnv;
use JBZoo\Utils\Vars;

/**
 * Class Env
 * @package JBZoo\CrossCMS
 */
class Env extends AbstractEnv
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getVersion()
    {
        return Vars::get($GLOBALS['wp_version'], '1.0.0');
    }

    /**
     * @return bool
     */
    public function isSite()
    {
        return !$this->isAdmin();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return is_admin();
    }
}
