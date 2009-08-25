<?php

require_once $symfony_libs.'/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    sfConfig::set('sf_plugins_dir', realpath(dirname(__FILE__) . '/../../../../..'));
    $this->enablePlugins(array('zxI18nRoutingPlugin'));
  }
}
