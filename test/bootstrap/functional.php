<?php

/*
 * This file is part of the zxI18nRoutingPlugin package.
 * (c) ZAANAX www.zaanax.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this plugin.
 */

require_once(dirname(__FILE__).'/dirs.php');
require_once(dirname(__FILE__).'/../functional/fixtures/config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test', isset($debug) ? $debug : true);

sfContext::createInstance($configuration);

// remove all cache
sf_functional_test_shutdown();

register_shutdown_function('sf_functional_test_shutdown');

function sf_functional_test_shutdown()
{
  sfToolkit::clearDirectory(sfConfig::get('sf_cache_dir'));
}
