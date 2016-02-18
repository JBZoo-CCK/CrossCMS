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

require_once realpath('./vendor/autoload.php');

// Set HTTP-Request variables
foreach ($_SERVER['argv'] as $argKey => $argValue) {
    if (strpos($argValue, '--jbzoo-env') === 0) {

        $query = str_replace('--jbzoo-env=', '', $argValue);

        parse_str($query, $queryVars);

        $_SERVER['QUERY_STRING']   = $query;
        $_SERVER['REQUEST_URI']    = '/?' . $query;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_REQUEST                  = $_GET = $queryVars;

        unset($_SERVER['argv'][$argKey]);
    }
}

PHPUnit_TextUI_Command::main();
