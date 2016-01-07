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

use JBZoo\CrossCMS\AbstractAssets;

/**
 * Class Assets
 * @package JBZoo\CrossCMS
 */
class Assets extends AbstractAssets
{
    /**
     * {@inheritdoc}
     */
    public function cssFile($file)
    {
        $handle = uniqid('crosscms-css-', true);
        \wp_enqueue_style($handle, $file);
    }

    /**
     * {@inheritdoc}
     */
    public function jsFile($file)
    {
        $handle = uniqid('crosscms-js-', true);
        wp_enqueue_script($handle, $file);
    }
    
    /**
     * {@inheritdoc}
     */
    public function cssCode($file)
    {
        $env = Cms::_('env');
        $code = sprintf('<style>%s</style>' . PHP_EOL, $code);
        $filter = $env->isAdmin() ? 'admin_print_styles' : 'wp_print_styles';
        
        add_action($filter, function () use ($code) {
            echo $code;
        });
    }
    
    /**
     * {@inheritdoc}
     */
    public function jsCode($code)
    {
        $env = Cms::_('env');
        $code = sprintf('<script>%s</script>' . PHP_EOL, $code);
        $filter = $env->isAdmin() ? 'admin_print_scripts' : 'wp_print_scripts';
        
        add_action($filter, function () use ($code) {
            echo $code;
        }, 30);
    }
}
