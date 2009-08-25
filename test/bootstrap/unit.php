<?php

/*
 * This file is part of the zxI18nRoutingPlugin package.
 * (c) ZAANAX www.zaanax.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this plugin.
 */

$_test_dir = realpath(dirname(__FILE__).'/..');

require_once(dirname(__FILE__).'/dirs.php');
require_once(dirname(__FILE__).'/../functional/fixtures/config/ProjectConfiguration.class.php');
$configuration = new ProjectConfiguration(realpath($_test_dir.'/functional/fixtures'));
include($configuration->getSymfonyLibDir().'/vendor/lime/lime.php');
