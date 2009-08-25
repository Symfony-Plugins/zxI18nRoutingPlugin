<?php

/*
 * This file is part of the zxI18nRoutingPlugin package.
 * (c) ZAANAX www.zaanax.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this plugin.
 */

$app = 'routing1';
include(dirname(__FILE__).'/../bootstrap/functional.php');

$b = new sfTestBrowser();
$b->test()->diag("");
$b->test()->diag("Testing routes generating");
$b->test()->diag("----------------------------------------------------------------------------");
$b->test()->diag("sf_i18n: true, culture_into_url: true, use_cultures: [en, de, pl, fr]");
$b->test()->diag("XLIFF files exists for \"de\" and \"pl\"");
$b->test()->diag("----------------------------------------------------------------------------");
$routing = sfContext::getInstance()->getRouting();
foreach ($routing->getRoutes() as $name => $route)
{
  $defaults = $route->getDefaults();
  $culture = isset($defaults['sf_culture']) ? "(sf_culture = ".$defaults['sf_culture'].")" : null;
  $b->test()->diag($name." => ".$route->getPattern()." ".$culture);
}
$b->test()->diag("----------------------------------------------------------------------------");
// default culture (en)
$b->
  get('/')->
  isStatusCode(200)->
  isUserCulture('en')
;

// choosen culture (pl)
$b->
  get('/pl/')->
  isStatusCode(200)->
  isUserCulture('pl')
;

// choosen culture (pl)
$b->
  get('/pl/testowanie/grupa/edycja')->
  isStatusCode(200)->
  isUserCulture('pl')
;

// choosen culture (de)
$b->
  get('/de/test/gruppe/sicht')->
  isStatusCode(200)->
  isUserCulture('de')
;

// choosen culture (fr)
$b->
  get('/fr/test/group/view')->
  isStatusCode(200)->
  isUserCulture('fr')
;

$b->test()->diag("URL generating on the base routing (current culture is \"fr\" after previous test)");
$b->test()->is(url_for('xz_test_route_1'),'/index.php/fr/test/group/view',"url_for('xz_test_route_1') gives /index.php/fr/test/group/view");
$b->test()->is(url_for('xz_test_route_1',array('sf_culture' => sfConfig::get('sf_default_culture'))),'/index.php/en/test/group/view',"url_for('xz_test_route_1',array('sf_culture' => sfConfig::get('sf_default_culture'))) gives /index.php/en/test/group/view");
$b->test()->is(url_for('xz_test_route_1',array('sf_culture'=>'pl')),'/index.php/pl/testowanie/grupa/widok',"url_for('xz_test_route_1',array('sf_culture'=>'pl')) gives /index.php/pl/testowanie/grupa/widok");
$b->test()->is(url_for('xz_test_route_1',array('sf_culture'=>'de')),'/index.php/de/test/gruppe/sicht',"url_for('xz_test_route_1',array('sf_culture'=>'de')) gives /index.php/de/test/gruppe/sicht");
$b->test()->is(url_for('xz_test_route_1',array('sf_culture'=>'fr')),'/index.php/fr/test/group/view',"url_for('xz_test_route_1',array('sf_culture'=>'fr')) gives /index.php/fr/test/group/view");
$b->test()->is(url_for('xz_test_route_1',array('sf_culture'=>'se')),'/index.php/se/test/group/view',"url_for('xz_test_route_1',array('sf_culture'=>'se')) gives /index.php/se/test/group/view");

$b->test()->diag("URL generating after culture change to \"pl\"");
sfContext::getInstance()->getUser()->setCulture('pl');
$b->test()->is(url_for('xz_test_route_1'),'/index.php/pl/testowanie/grupa/widok',"url_for('xz_test_route_1') gives /index.php/pl/testowanie/grupa/widok");




// Propel route test
$r = sfContext::getInstance()->getRouting();
$r->clearRoutes();
$r->connect('xz_test_route_4', new sfPropelRoute('/test/group/list/:page',array('page'=>1),array(),array('model'=>'zxTestPropelRoutes', 'type'=> 'object')));
$routes = $r->getRoutes();
$b->test()->is(count($routes), 4, 'sfPropelRoute generates well');

// Propel route collection test
$r = sfContext::getInstance()->getRouting();
$r->clearRoutes();
$r->connect('xz_test_route_5', new sfPropelRouteCollection(array(
      'name'                 => 'zx_test_propel_route',
      'model'                => 'zxTestPropelRoutes',
      'module'               => 'zxTestPropelRoutes',
      'prefix_path'          => 'zx_test_propel_route',
      'with_wildcard_routes' => true,
      'requirements'         => array(),
    )));
$routes = $r->getRoutes();
$b->test()->is(count($routes), 20, 'sfPropelRouteCollection generates well');
