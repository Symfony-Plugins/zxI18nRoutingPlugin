<?php

/*
 * This file is part of the zxI18nRoutingPlugin package.
 * (c) ZAANAX www.zaanax.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this plugin.
 */

/*
 * This tests works fine with lime version > 1.0.6 (currently the trunk version)
 * If you use older lime versions tests may show "dubious" error, but 
 * individual tests works fine
 */

require_once(dirname(__FILE__).'/../bootstrap/dirs.php');
require_once($symfony_libs.'/lib/vendor/lime/lime.php');

class lime_symfony extends lime_harness
{
  protected function get_relative_file($file)
  {
    $file = str_replace(DIRECTORY_SEPARATOR, '/', str_replace(array(
      realpath($this->base_dir).DIRECTORY_SEPARATOR,
      realpath($this->base_dir.'/../lib/plugins').DIRECTORY_SEPARATOR,
      $this->extension,
    ), '', $file));

    return preg_replace('#^(.*?)Plugin/test/(unit|functional)/#', '[$1] $2/', $file);
  }
}

require_once($symfony_libs.'/lib/util/sfToolkit.class.php');
if($files = glob(sfToolkit::getTmpDir().DIRECTORY_SEPARATOR.'/sf_autoload_unit_*'))
{
  foreach ($files as $file)
  {
    unlink($file);
  }
}

// update sfCoreAutoload
require_once($symfony_libs.'/lib/autoload/sfCoreAutoload.class.php');
sfCoreAutoload::make();

$h = new lime_symfony(new lime_output_color());
$h->base_dir = realpath(dirname(__FILE__).'/..');

$h->register(sfFinder::type('file')->prune('fixtures')->name('*Test.php')->in(array_merge(
  // unit tests
  array($h->base_dir.'/unit'),
  glob($h->base_dir.'/../lib/plugins/*/test/unit'),

  // functional tests
  array($h->base_dir.'/functional'),
  glob($h->base_dir.'/../lib/plugins/*/test/functional'),

  // other tests
  array($h->base_dir.'/other')
)));

exit($h->run() ? 0 : 1);
