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

use JBZoo\Utils\Env;

// $_SERVER['SCRIPT_NAME'] = '/index.php'; // #FUCK!!! https://bugs.php.net/bug.php?id=61286

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = $_SERVER['DOCUMENT_ROOT'] . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require_once __DIR__ . '/../../vendor/autoload.php';

if (!class_exists('JBZooPHPUnitCoverageWrapper')) {
    /**
     * Class JBZooPHPUnitCoverageWrapper
     * @codeCoverageIgnore
     */
    class JBZooPHPUnitCoverageWrapper
    {
        /**
         * @var PHP_CodeCoverage
         */
        protected $_coverage;
        /**
         * @var string
         */
        protected $_covRoot;
        /**
         * @var string
         */
        protected $_covDir;
        /**
         * @var string
         */
        protected $_covHash;
        /**
         * @var string
         */
        protected $_covResult;

        /**
         * JBZooPHPUnit_Coverage constructor.
         * @SuppressWarnings(PHPMD.Superglobals)
         */
        public function __construct()
        {
            if (Env::hasXdebug() && isset($_REQUEST['jbzoo-phpunit'])) {

                $cmsType  = $_REQUEST['jbzoo-phpunit-type'];
                $testName = $_REQUEST['jbzoo-phpunit-test'];

                $this->_covRoot = realpath(__DIR__ . '/../..');
                $this->_covDir  = realpath($this->_covRoot . '/src');
                $this->_covHash = implode('_', [
                    md5(serialize($_REQUEST)),
                    mt_rand(0, 100000000)
                ]);

                $this->_covResult = realpath($this->_covRoot . '/build/coverage_cov')
                    . '/' . $cmsType . '-' . $testName . '.cov';

                $covFilter = new PHP_CodeCoverage_Filter();
                $covFilter->addDirectoryToWhitelist($this->_covDir);
                $this->_coverage = new PHP_CodeCoverage(null, $covFilter);
            }
        }

        /**
         * Save report
         */
        public function __destruct()
        {
            if ($this->_coverage) {
                $this->_coverage->stop();
                $report = new PHP_CodeCoverage_Report_PHP();
                $report->process($this->_coverage, $this->_covResult);
            }
        }

        /**
         * @param Closure $callback
         * @return mixed
         */
        public function init(\Closure $callback)
        {
            if ($this->_coverage) {
                $this->_coverage->start($this->_covHash, true);
            }
            return $callback();
        }
    }
}

$coverageWrapper = new JBZooPHPUnitCoverageWrapper();
return $coverageWrapper->init(function () {
    require_once $_SERVER['SCRIPT_FILENAME'];
});
