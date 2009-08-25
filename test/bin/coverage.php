<?php

/*
 * This file is part of the zxI18nRoutingPlugin package.
 * (c) ZAANAX www.zaanax.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this plugin.
 */

require_once(dirname(__FILE__).'/../bootstrap/dirs.php');
require_once($symfony_libs.'/lib/vendor/lime/lime.php');
require_once($symfony_libs.'/lib/util/sfFinder.class.php');

$h = new lime_harness(new lime_output_color());
$h->base_dir = realpath(dirname(__FILE__).'/..');

// unit tests
$h->register_glob($h->base_dir.'/unit/*Test.php');

// functional tests
$h->register_glob($h->base_dir.'/functional/*Test.php');

$c = new lime_coverage($h);
$c->extension = '.class.php';
$c->verbose = false;
$c->base_dir = realpath(dirname(__FILE__).'/../../lib');

$finder = sfFinder::type('file')->name('*.php')->prune('task');
$c->register($finder->in($c->base_dir));
$c->run();
