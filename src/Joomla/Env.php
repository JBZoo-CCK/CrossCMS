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

use JBZoo\CrossCMS\AbstractEnv;

/**
 * Class Env
 * @package JBZoo\CrossCMS
 */
class Env extends AbstractEnv
{
    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        return JVERSION;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isSite()
    {
        return \JFactory::getApplication()->isSite();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isAdmin()
    {
        return \JFactory::getApplication()->isAdmin();
    }
}
