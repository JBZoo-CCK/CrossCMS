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

namespace JBZoo\PHPUnit;

use JBZoo\CrossCMS\Cms;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class AssetsTest
 * @package JBZoo\PHPUnit
 */
class AssetsTest extends PHPUnit
{

    public function testCSS()
    {
        $command = null;

        if (Cms::_('type') == Cms::TYPE_JOOMLA) {

            $html = $this->_cliExec('php ./tests/web-joomla.php');

            $crawler = new Crawler($html);
            $scripts = $crawler->filter('script[src="/media/jui/js/jquery.min.js"]');

            //echo $html;
            //cliMessage('HTML :' . $html);
            cliMessage('HTML length=' . strlen($html));
            cliMessage('Scripts count = ' . count($scripts));
        }
    }

    /**
     * @param string $command
     * @return string
     */
    protected function _cliExec($command)
    {
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
